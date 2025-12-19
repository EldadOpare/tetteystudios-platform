# TetteyStudios+

A modern film streaming and crowdfunding platform for independent filmmakers.

## Features

- **User Authentication** - Secure login/signup system with role-based access (Viewer, Filmmaker, Admin)
- **Film Streaming** - Watch independent films with support for YouTube, Vimeo, and direct video uploads
- **Crowdfunding** - Support filmmakers through project donations
- **Reviews & Ratings** - Community engagement through film reviews
- **Admin Dashboard** - Content moderation and approval system
- **Filmmaker Dashboard** - Upload and manage film projects
- **Search & Filter** - Find films by category, title, or synopsis

## Technology Stack

- **Backend:** PHP 7.4+
- **Database:** Supabase (PostgreSQL)
- **Frontend:** HTML, CSS, JavaScript
- **Hosting:** Vercel (Serverless)
- **Storage:** Supabase Storage

## Project Structure

```
solely_deployment-main/
├── api/                      # PHP backend
│   ├── src/                  # Core PHP classes
│   │   ├── auth.php          # Authentication functions
│   │   ├── db.php            # Database configuration
│   │   └── Supabase.php      # Supabase API client
│   ├── index.php             # Homepage
│   ├── login.php             # Login page
│   ├── signup.php            # Registration page
│   ├── watch.php             # Film player page
│   ├── filmmaker_dashboard.php
│   ├── viewer_dashboard.php
│   ├── admin_dashboard.php
│   └── upload_film.php       # Film upload form
├── public/                   # Static assets
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── images/               # Image assets
├── vercel.json               # Vercel configuration
├── .env.example              # Environment variables template
├── DEPLOYMENT.md             # Deployment guide
└── README.md                 # This file
```

## Local Development Setup

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd solely_deployment-main
   ```

2. **Set up environment variables**
   ```bash
   cp .env.example .env
   ```

   Edit `.env` and add your Supabase credentials:
   ```
   SUPABASE_URL=https://your-project-id.supabase.co
   SUPABASE_KEY=your-supabase-anon-key
   ```

3. **Set up Supabase Database**
   - Create a new Supabase project
   - Run the database schema (create tables: users, user_profiles, films, categories, reviews, donations, film_credits)
   - Configure Row Level Security policies

4. **Run locally with PHP**
   ```bash
   cd api
   php -S localhost:8000
   ```

   Visit http://localhost:8000 in your browser

## Deployment

See [DEPLOYMENT.md](DEPLOYMENT.md) for detailed deployment instructions to Vercel.

## Database Schema

### users
- id (uuid, primary key)
- username (text, unique)
- email (text, unique)
- password_hash (text)
- created_at (timestamp)

### user_profiles
- id (uuid, primary key)
- user_id (uuid, foreign key → users)
- role (text: 'viewer', 'filmmaker', 'admin')
- avatar_url (text)

### films
- id (uuid, primary key)
- filmmaker_id (uuid, foreign key → users)
- category_id (uuid, foreign key → categories)
- title (text)
- synopsis (text)
- video_url (text)
- trailer_url (text)
- poster_url (text)
- thumbnail_url (text)
- duration_minutes (integer)
- funding_goal (numeric)
- funding_raised (numeric)
- status (text: 'pending', 'approved', 'rejected')
- visibility (text: 'public', 'private')
- created_at (timestamp)

### categories
- id (uuid, primary key)
- name (text, unique)

### reviews
- id (uuid, primary key)
- user_id (uuid, foreign key → users)
- film_id (uuid, foreign key → films)
- rating (integer, 1-5)
- comment (text)
- created_at (timestamp)

### donations
- id (uuid, primary key)
- user_id (uuid, foreign key → users)
- film_id (uuid, foreign key → films)
- amount (numeric)
- message (text)
- created_at (timestamp)

### film_credits
- id (uuid, primary key)
- film_id (uuid, foreign key → films)
- role (text: 'Director', 'Writer', 'Producer', etc.)
- name (text)

## Security Features

- ✅ Password hashing with PHP's `password_hash()`
- ✅ SQL injection protection via Supabase parameterized queries
- ✅ XSS protection with `htmlspecialchars()`
- ✅ Environment variables for sensitive credentials
- ✅ Session-based authentication
- ✅ Role-based access control

## Known Issues & Limitations

1. **Session Storage:** Sessions are stored in the file system, which may not persist well on Vercel's serverless environment. Consider migrating to database-backed sessions or JWT tokens.

2. **File Uploads:** Large video uploads should use external hosting (YouTube, Vimeo) for better performance.

3. **CORS:** If accessing the API from a different domain, you may need to configure CORS headers.

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is proprietary. All rights reserved.

## Support

For issues or questions:
- Check the [DEPLOYMENT.md](DEPLOYMENT.md) guide
- Review Vercel documentation: https://vercel.com/docs
- Review Supabase documentation: https://supabase.com/docs

## Credits

Built with ❤️ for independent filmmakers
