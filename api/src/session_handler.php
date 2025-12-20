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
            // Don't write empty sessions
            if (empty($data)) {
                return true;
            }

            $encodedData = base64_encode($data);
            $now = date('Y-m-d H:i:s');

            // Try to insert or update using upsert pattern
            try {
                // First try to insert
                $this->supabase->request('POST', 'sessions', [
                    'session_id' => $id,
                    'data' => $encodedData,
                    'last_activity' => $now
                ]);
            } catch (Exception $e) {
                // If insert fails (duplicate key), try update
                $this->supabase->request('PATCH', "sessions?session_id=eq.$id", [
                    'data' => $encodedData,
                    'last_activity' => $now
                ]);
            }

            return true;
        } catch (Exception $e) {
            error_log("Session write error for ID $id: " . $e->getMessage());
            // Return true anyway to prevent session write failures from breaking the app
            return true;
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
