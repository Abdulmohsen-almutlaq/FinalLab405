const API_BASE_URL = 'http://localhost:8080/api/'; // Adjust this URL to your API endpoint

export const getAllBookmarks = async () => {
    const response = await fetch(`${API_BASE_URL}display.php`);
    if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(errorData.error || `HTTP error! Status: ${response.status}`);
    }
    return response.json();
};

export const createBookmark = async (newBookmarkData) => {
    const response = await fetch(`${API_BASE_URL}create.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ url: newBookmarkData.url, title: newBookmarkData.title }),
    });
    
    const responseData = await response.json();
    if (!response.ok) {
        throw new Error(responseData.msg || responseData.error || `HTTP error! Status: ${response.status}`);
    }
    if (!responseData.id) {
        throw new Error(responseData.msg || 'Failed to add bookmark, ID not returned.');
    }
    return responseData; 
};

export const updateBookmarkById = async (id, bookmarkData) => {
    const response = await fetch(`${API_BASE_URL}update.php`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id, ...bookmarkData }),
    });

    const responseData = await response.json();
    if (!response.ok) {
        throw new Error(responseData.msg || responseData.error || `HTTP error! Status: ${response.status}`);
    }
    return responseData;
};

export const deleteBookmarkById = async (id) => {
    const response = await fetch(`${API_BASE_URL}delete.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id }),
    });

    const responseData = await response.json();
    if (!response.ok) {
        throw new Error(responseData.msg || responseData.error || `HTTP error! Status: ${response.status}`);
    }
    return responseData;
};
