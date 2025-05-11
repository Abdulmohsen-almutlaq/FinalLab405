# Lab Final 405


Web app to store and manage bookmarks.

##  Overview

React + PHP + PostgreSQL app.

##  Demo

<div align="center">
  <iframe width="560" height="315" src="https://www.youtube.com/embed/UkkaJjSIh8Y" title="Bookmark Manager Demo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
</div>

Live Demo: https://www.youtube.com/watch?v=UkkaJjSIh8Y

##  Features

- CRUD API 
- React UI

##  Setup

### Backend
```bash
cd Backend
docker-compose up -d
```

### Frontend
```bash
cd Bookmark
npm install
npm run dev
```

## 👨‍💻 API Endpoints

- `GET /api/display.php` - Get all bookmarks
- `POST /api/create.php` - Create a new bookmark
- `PUT /api/update.php` - Update an existing bookmark
- `DELETE /api/delete.php` - Delete a bookmark

## 📝 License

This project is part of CPIT-405 coursework.
