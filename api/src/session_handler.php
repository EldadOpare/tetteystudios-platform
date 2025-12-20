<?php
// Custom session handler for Vercel serverless using Supabase
class SupabaseSessionHandler implements SessionHandlerInterface
{
    private $supabase;
    private $lifetime;

    public function __construct($supabase, $lifetime = 86400)
    {
        $this->supabase = $supabase;
        $this->lifetime = $lifetime;
    }

    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read($id): string|false
    {
        try {
            $result = $this->supabase->request('GET', 'sessions', [
                'session_id' => "eq.$id",
                'select' => 'data,last_activity'
            ]);

            if (!empty($result)) {
                $session = $result[0];
                // Check if session is expired
                $lastActivity = strtotime($session['last_activity']);
                if (time() - $lastActivity > $this->lifetime) {
                    // Session expired, delete it
                    $this->destroy($id);
                    return '';
                }
                return base64_decode($session['data']);
            }
        } catch (Exception $e) {
            error_log("Session read error: " . $e->getMessage());
        }
        return '';
    }

    public function write($id, $data): bool
    {
        try {
            $encodedData = base64_encode($data);
            $now = date('Y-m-d H:i:s');

            // Try to update first
            $existing = $this->supabase->request('GET', 'sessions', [
                'session_id' => "eq.$id"
            ]);

            if (!empty($existing)) {
                // Update existing session
                $this->supabase->request('PATCH', "sessions?session_id=eq.$id", [
                    'data' => $encodedData,
                    'last_activity' => $now
                ]);
            } else {
                // Insert new session
                $this->supabase->request('POST', 'sessions', [
                    'session_id' => $id,
                    'data' => $encodedData,
                    'last_activity' => $now
                ]);
            }
            return true;
        } catch (Exception $e) {
            error_log("Session write error: " . $e->getMessage());
            return false;
        }
    }

    public function destroy($id): bool
    {
        try {
            $this->supabase->request('DELETE', "sessions?session_id=eq.$id");
            return true;
        } catch (Exception $e) {
            error_log("Session destroy error: " . $e->getMessage());
            return false;
        }
    }

    public function gc($maxlifetime): int|false
    {
        try {
            $expired = date('Y-m-d H:i:s', time() - $maxlifetime);
            $this->supabase->request('DELETE', "sessions?last_activity=lt.$expired");
            return 0; // Return number of deleted sessions (we don't track this)
        } catch (Exception $e) {
            error_log("Session GC error: " . $e->getMessage());
            return false;
        }
    }
}
