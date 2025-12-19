# 🚨 CRITICAL: Update Vercel Environment Variables

## Issue
You're getting `Invalid API key` error because the Supabase key in Vercel is incorrect.

---

## ✅ Fix Now (2 minutes)

### Step 1: Go to Vercel Project Settings
1. Open https://vercel.com/dashboard
2. Click on your **tetteystudios-platform** project
3. Click **Settings** tab
4. Click **Environment Variables** in the left sidebar

### Step 2: Update/Add Environment Variables

**Delete the old variables if they exist, then add these:**

#### Variable 1: SUPABASE_URL
```
SUPABASE_URL
```
**Value:**
```
https://qqwwtartsqtxyoirsiio.supabase.co
```

#### Variable 2: SUPABASE_KEY
```
SUPABASE_KEY
```
**Value (copy this EXACT key):**
```
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InFxd3d0YXJ0c3F0eHlvaXJzaWlvIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MzQ1ODA2MjAsImV4cCI6MjA1MDE1NjYyMH0.Np6w-3vHl8vSZQkh0on-u4hY0vPexYwbdFSV7TIgpuE
```

⚠️ **IMPORTANT:** Make sure you:
- Select **Production**, **Preview**, AND **Development** for both variables
- Copy the ENTIRE key (it's very long!)
- No extra spaces before or after

### Step 3: Redeploy
1. Go to your project's **Deployments** tab
2. Click the **three dots** (...) on the latest deployment
3. Click **Redeploy**
4. Check **"Use existing Build Cache"** = OFF
5. Click **Redeploy**

---

## 🎨 CSS Should Also Be Fixed

The latest push also fixed all CSS/JS paths to work with Vercel's structure.

After redeploying with correct environment variables:
- ✅ CSS should load on all pages
- ✅ Signup/Login should work
- ✅ Database connections should work

---

## 🧪 Test After Redeployment

1. Visit your site
2. Try to **Sign Up** - should work now!
3. Check if CSS loads on all pages
4. Try logging in

---

## Still Getting Errors?

If you still see `Invalid API key` after redeploying:

1. **Double-check the key** - Make sure it's the EXACT key above (very long, starts with `eyJ`)
2. **Check Supabase dashboard** - Go to https://supabase.com/dashboard
   - Select your project
   - Settings → API
   - Copy the **anon/public** key
   - Update in Vercel if different

---

**After fixing, your app should work perfectly!** 🎉
