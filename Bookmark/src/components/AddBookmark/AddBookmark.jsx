import React, { useState } from 'react';
import './AddBookmark.css';

function AddBookmark({ onAddBookmark }) {
  const [bookmarkData, setBookmarkData] = useState({
    title: '',
    url: ''
  });

  const handleChange = (e) => {
    const { name, value } = e.target;
    setBookmarkData(prevData => ({
      ...prevData,
      [name]: value
    }));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    
    // Validate form
    if (!bookmarkData.title || !bookmarkData.url) {
      alert('Title and URL are required!');
      return;
    }
    
    // Call the parent function to add the bookmark
    onAddBookmark(bookmarkData);
    
    // Reset form
    setBookmarkData({
      title: '',
      url: ''
    });
  };

  return (
    <div className="add-bookmark-container">
      <h2 className="add-bookmark-title">Add New Bookmark</h2>
      
      <form className="add-bookmark-form" onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="title">Title:</label>
          <input
            type="text"
            id="title"
            name="title"
            value={bookmarkData.title}
            onChange={handleChange}
            placeholder="Enter bookmark title"
            required
          />
        </div>
        
        <div className="form-group">
          <label htmlFor="url">URL:</label>
          <input
            type="url"
            id="url"
            name="url"
            value={bookmarkData.url}
            onChange={handleChange}
            placeholder="https://example.com"
            required
          />
        </div>
        
        <button type="submit" className="submit-button">Add Bookmark</button>
      </form>
    </div>
  );
}

export default AddBookmark;
