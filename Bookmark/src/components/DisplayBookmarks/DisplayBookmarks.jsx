import React, { useState, useEffect } from 'react';
import './DisplayBookmarks.css';

function DisplayBookmarks({ bookmarks, onEditBookmark }) { 
  const [isVisible, setIsVisible] = useState(false);

  // Animation on mount
  useEffect(() => {
    setIsVisible(true);
  }, []);

  // The component no longer handles filtering internally.
  // It expects the 'bookmarks' prop to be the list it should render.

  const handleEdit = (bookmark) => {
    // For a real edit, you'd likely open a modal or inline form
    // For this example, we'll prompt for new values
    const newTitle = prompt("Enter new title:", bookmark.title);
    const newUrl = prompt("Enter new URL:", bookmark.url);

    if (newTitle !== null && newUrl !== null && (newTitle !== bookmark.title || newUrl !== bookmark.url)) {
      onEditBookmark(bookmark.id, { title: newTitle, url: newUrl });
    }
  };

  return (
    <div className={`bookmarks-container ${isVisible ? 'fade-in' : ''}`}>
      <h2 className="bookmarks-title">My Bookmarks</h2>
      
      {/* Search input and related logic removed from this component */}
      
      {bookmarks && bookmarks.length > 0 ? (
        <ul className="bookmarks-list">
          {bookmarks.map((bookmark, index) => (
            <li 
              key={bookmark.id || index} 
              className="bookmark-item"
              style={{ animationDelay: `${index * 0.1}s` }}
            >
              <a 
                href={bookmark.url} 
                target="_blank" 
                rel="noopener noreferrer"
                className="bookmark-link"
              >
                <div className="bookmark-content">
                  <h3 className="bookmark-title">{bookmark.title}</h3>
                  <p className="bookmark-url">{bookmark.url}</p>
                  {bookmark.dateAdded && <p className="bookmark-date">Added: {bookmark.dateAdded}</p>}
                </div>
              </a>
              <button onClick={() => handleEdit(bookmark)} className="edit-button">Edit</button>
            </li>
          ))}
        </ul>
      ) : (
        <p className="no-bookmarks-message">No bookmarks to display.</p>
      )}
    </div>
  );
}

export default DisplayBookmarks;
