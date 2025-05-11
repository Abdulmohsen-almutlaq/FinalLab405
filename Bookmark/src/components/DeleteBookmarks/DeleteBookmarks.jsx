import React from 'react';
import './DeleteBookmarks.css';

function DeleteBookmarks({ bookmarks, onDeleteBookmark }) {
  return (
    <div className="delete-bookmarks-container">
      <h2 className="delete-bookmarks-title">Delete Bookmarks</h2>
      
      {bookmarks && bookmarks.length > 0 ? (
        <ul className="delete-bookmarks-list">          {bookmarks.map((bookmark) => (
            <li key={bookmark.id} className="delete-bookmark-item">
              <div className="delete-bookmark-content">
                <h3 className="delete-bookmark-title">{bookmark.title}</h3>
                <p className="delete-bookmark-url">{bookmark.url}</p>
              </div>
              <button 
                className="delete-button"
                onClick={() => onDeleteBookmark(bookmark.id)}
                title="Delete this bookmark"
              >
                Delete
              </button>
            </li>
          ))}
        </ul>
      ) : (
        <p className="no-bookmarks-message">No bookmarks to delete.</p>
      )}
    </div>
  );
}

export default DeleteBookmarks;
