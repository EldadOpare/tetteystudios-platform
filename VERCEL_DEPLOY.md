# 🚀 Deploy to Vercel - Step by Step

Your code is now on GitHub! Let's deploy it to Vercel.

## 📦 Repository
**GitHub URL:** https://github.com/EldadOpare/tetteystudios-platform

---

## 🎯 Deploy to Vercel (3 Minutes)

### Step 1: Go to Vercel Dashboard

1. Open: https://vercel.com/new
2. Click **"Import Git Repository"**

### Step 2: Import Your Repository

1. You should see: **EldadOpare/tetteystudios-platform**
2. Click **"Import"**

### Step 3: Configure Project

**Framework Preset:** Other

**Root Directory:** `./` (leave as is)

**Build Command:** (leave empty)

**Output Directory:** (leave empty)

**Install Command:** (leave empty)

### Step 4: Add Environment Variables ⚠️ IMPORTANT!

Click **"Environment Variables"** and add these TWO variables:

#### Variable 1:
- **Name:** `SUPABASE_URL`
- **Value:** `https://qqwwtartsqtxyoirsiio.supabase.co`

#### Variable 2:
- **Name:** `SUPABASE_KEY`
- **Value:** `eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InFxd3d0YXJ0c3F0eHlvaXJzaWlvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzQ1ODA2MjAsImV4cCI6MjA1MDE1NjYyMH0.Np6w-3vHl8vSZQkh0on-u4hY0vPexYwbdFSV7TIgpuE`

**Make sure both are set for:** Production, Preview, and Development

### Step 5: Deploy!

Click **"Deploy"** and wait 1-2 minutes.

---

## ✅ After Deployment

Once deployed, you'll get a URL like:
`https://tetteystudios-platform.vercel.app`

### Test These Pages:

1. **Homepage:** `https://your-url.vercel.app`
2. **Login:** `https://your-url.vercel.app/login.php`
3. **Signup:** `https://your-url.vercel.app/signup.php`

---

## 🗄️ Set Up Database (REQUIRED!)

Your app won't work until you create the database tables in Supabase.

### Quick Database Setup:

1. Go to: https://supabase.com/dashboard
2. Select your project: **qqwwtartsqtxyoirsiio**
3. Click **SQL Editor** → **New Query**
4. Copy and paste this SQL:

```sql
-- Users table
CREATE TABLE users (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  username TEXT UNIQUE NOT NULL,
  email TEXT UNIQUE NOT NULL,
  password_hash TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT NOW()
);

-- User profiles
CREATE TABLE user_profiles (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  user_id UUID REFERENCES users(id) ON DELETE CASCADE,
  role TEXT DEFAULT 'viewer',
  avatar_url TEXT,
  created_at TIMESTAMP DEFAULT NOW()
);

-- Categories
CREATE TABLE categories (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  name TEXT UNIQUE NOT NULL
);

-- Insert default categories
INSERT INTO categories (name) VALUES
  ('Drama'), ('Action'), ('Comedy'), ('Documentary'), ('Thriller'), ('Horror'), ('Sci-Fi');

-- Films table
CREATE TABLE films (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  filmmaker_id UUID REFERENCES users(id),
  category_id UUID REFERENCES categories(id),
  title TEXT NOT NULL,
  synopsis TEXT,
  video_url TEXT,
  trailer_url TEXT,
  poster_url TEXT,
  thumbnail_url TEXT,
  duration_minutes INTEGER DEFAULT 0,
  funding_goal NUMERIC DEFAULT 0,
  funding_raised NUMERIC DEFAULT 0,
  status TEXT DEFAULT 'pending',
  visibility TEXT DEFAULT 'public',
  created_at TIMESTAMP DEFAULT NOW()
);

-- Reviews
CREATE TABLE reviews (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  user_id UUID REFERENCES users(id),
  film_id UUID REFERENCES films(id) ON DELETE CASCADE,
  rating INTEGER CHECK (rating >= 1 AND rating <= 5),
  comment TEXT,
  created_at TIMESTAMP DEFAULT NOW(),
  UNIQUE(user_id, film_id)
);

-- Donations
CREATE TABLE donations (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  user_id UUID REFERENCES users(id),
  film_id UUID REFERENCES films(id) ON DELETE CASCADE,
  amount NUMERIC NOT NULL,
  message TEXT,
  created_at TIMESTAMP DEFAULT NOW()
);

-- Film credits
CREATE TABLE film_credits (
  id UUID DEFAULT gen_random_uuid() PRIMARY KEY,
  film_id UUID REFERENCES films(id) ON DELETE CASCADE,
  role TEXT NOT NULL,
  name TEXT NOT NULL
);

-- Enable Row Level Security
ALTER TABLE films ENABLE ROW LEVEL SECURITY;

-- Allow public to read approved films
CREATE POLICY "Public can view approved films" ON films
  FOR SELECT USING (status = 'approved' AND visibility = 'public');
```

5. Click **Run** or press `Ctrl+Enter`

---

## 👤 Create Admin Account

After your app is deployed and database is set up:

1. Visit your app: `https://your-url.vercel.app/signup.php`
2. Register a new account (any role)
3. Go back to Supabase SQL Editor
4. Run this query (replace `your-username` with your actual username):

```sql
UPDATE user_profiles
SET role = 'admin'
WHERE user_id = (SELECT id FROM users WHERE username = 'your-username');
```

Now you can access the admin dashboard!

---

## 🎉 You're Live!

Your platform is now deployed at:
- **Production URL:** Check your Vercel dashboard
- **GitHub Repo:** https://github.com/EldadOpare/tetteystudios-platform

### Next Steps:

1. ✅ Test user registration
2. ✅ Test login
3. ✅ Upload a test film (as filmmaker)
4. ✅ Approve it (as admin)
5. ✅ Test donations
6. ✅ Test reviews

---

## ⚙️ Custom Domain (Optional)

To add your own domain:

1. Go to Vercel Dashboard → Your Project
2. Click **Settings** → **Domains**
3. Add your domain
4. Follow the DNS configuration instructions

---

## 🔧 Troubleshooting

### Issue: "Supabase configuration missing"
**Solution:** Make sure you added BOTH environment variables in Vercel (Step 4)

### Issue: Database errors
**Solution:** Run all the SQL commands in the "Set Up Database" section

### Issue: Can't login
**Solution:**
1. Make sure database tables exist
2. Try registering a new account first

### Issue: 404 errors
**Solution:** The vercel.json is configured for PHP routing. If you get 404s, check Vercel Function Logs

---

## 📊 Monitor Your App

- **Vercel Logs:** https://vercel.com/dashboard → Your Project → Logs
- **Supabase Logs:** https://supabase.com/dashboard → Your Project → Logs

---

## 🎬 Happy Streaming!

Your TetteyStudios+ platform is ready to host independent films!
