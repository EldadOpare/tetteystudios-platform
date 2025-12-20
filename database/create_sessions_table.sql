-- Create sessions table for database-backed sessions on Vercel
-- Run this entire script in Supabase SQL Editor

-- Drop the table if it exists (to start fresh)
DROP TABLE IF EXISTS sessions CASCADE;

-- Create sessions table
CREATE TABLE sessions (
    id BIGSERIAL PRIMARY KEY,
    session_id VARCHAR(255) UNIQUE NOT NULL,
    data TEXT NOT NULL,
    last_activity TIMESTAMP NOT NULL DEFAULT NOW(),
    created_at TIMESTAMP DEFAULT NOW()
);

-- Create indexes for faster lookups
CREATE INDEX idx_sessions_session_id ON sessions(session_id);
CREATE INDEX idx_sessions_last_activity ON sessions(last_activity);

-- Enable RLS (Row Level Security)
ALTER TABLE sessions ENABLE ROW LEVEL SECURITY;

-- Create policy to allow all operations (sessions need to be accessible)
-- Note: We use permissive policy since sessions need to work across all users
DROP POLICY IF EXISTS "Allow all session operations" ON sessions;
CREATE POLICY "Allow all session operations" ON sessions
    FOR ALL
    USING (true)
    WITH CHECK (true);
