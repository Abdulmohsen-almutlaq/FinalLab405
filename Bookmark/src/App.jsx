import { useState, useEffect } from 'react'
import './App.css'

// Import our components
import DisplayBookmarks from './components/DisplayBookmarks/DisplayBookmarks'
import AddBookmark from './components/AddBookmark/AddBookmark'
import DeleteBookmarks from './components/DeleteBookmarks/DeleteBookmarks'

// Import API service functions
import { getAllBookmarks, createBookmark, deleteBookmarkById, updateBookmarkById } from './api/bookmarkService';


function App() {
  // Use state to store bookmarks
  const [bookmarks, setBookmarks] = useState([]); // Array of bookmarks
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  
  // Fetch bookmarks from the API
  useEffect(() => {
    fetchBookmarks();
  }, []);
  
  // Function to fetch all bookmarks
  const fetchBookmarks = async () => {
    try {
      setLoading(true);
      const data = await getAllBookmarks();
      setBookmarks(data);
      setError(null);
    } catch (err) {
      console.error('Error fetching bookmarks:', err);
      setError(err.message || 'Failed to load bookmarks. Please try again later.');
    } finally {
      setLoading(false);
    }
  };

  // Function to add a new bookmark
  const handleAddBookmark = async (newBookmarkData) => { // newBookmarkData should be { title, url }
    try {
      const response = await createBookmark(newBookmarkData);
      
      // Immediately update UI with new bookmark (including ID from response)
      const newBookmark = {
        id: response.id,
        title: newBookmarkData.title,
        url: newBookmarkData.url,
        dateAdded: response.dateAdded || new Date().toISOString()
      };
      
      setBookmarks(prevBookmarks => [newBookmark, ...prevBookmarks]);
    } catch (err) {
      console.error('Error adding bookmark:', err);
      alert(err.message || 'Failed to add bookmark. Please try again.');
    }
  };

  const handleUpdateBookmark = async (id, updatedData) => { // updatedData is { url, title }
    try {
      // Optimistic update - update UI immediately before API call completes
      const bookmarksCopy = [...bookmarks];
      const updatedBookmarks = bookmarks.map(bookmark => 
        bookmark.id === id ? { ...bookmark, ...updatedData } : bookmark
      );
      
      // Update UI immediately
      setBookmarks(updatedBookmarks);
      
      // Send update to server
      await updateBookmarkById(id, updatedData);
    } catch (err) {
      console.error('Error updating bookmark:', err);
      alert(err.message || 'Failed to update bookmark. Please try again.');
      // Revert to original state if the API call failed
      fetchBookmarks();
    }
  };

  // Function to delete a bookmark
  const handleDeleteBookmark = async (id) => {
    try {
      // Optimistic update - remove from UI before API call completes
      const filteredBookmarks = bookmarks.filter(bookmark => bookmark.id !== id);
      setBookmarks(filteredBookmarks);
      
      // Send delete request to server
      await deleteBookmarkById(id);
    } catch (err) {
      console.error('Error deleting bookmark:', err);
      alert(err.message || 'Failed to delete bookmark. Please try again.');
      // Revert to original state if the API call failed
      fetchBookmarks();
    }
  };

  return (
    <div className="app-container">
      <header className="app-header">
        <h1>Bookmark Manager</h1>
      </header>
      
      <main className="app-main">

        
        {loading ? (
          <div className="loading-spinner">
            <p>Loading bookmarks...</p>
          </div>
        ) : (
          <div className="app-columns">
            <div className="column">
              <DisplayBookmarks bookmarks={bookmarks} onEditBookmark={handleUpdateBookmark} />
            </div>
            
            <div className="column">
              <AddBookmark onAddBookmark={handleAddBookmark} />
              <div className="spacer"></div>
              <DeleteBookmarks 
                bookmarks={bookmarks} 
                onDeleteBookmark={handleDeleteBookmark} 
              />
            </div>
          </div>
        )}
      </main>
    </div>
  )
}

export default App
