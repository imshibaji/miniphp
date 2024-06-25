<?php
namespace Shibaji\Core;

class WordPress
{
    private $baseURL;
    private $authToken;

    /**
     * WordPressManager constructor.
     *
     * @param string $baseURL The base URL of the WordPress site.
     * @param string $authToken The authentication token or API key for accessing the REST API.
     */
    public function __construct($baseURL, $authToken)
    {
        $this->baseURL = rtrim($baseURL, '/') . '/wp-json/wp/v2/';
        $this->authToken = $authToken;
    }

    /**
     * Retrieves posts from WordPress.
     *
     * @param array $params Optional parameters for filtering, e.g., ['per_page' => 10].
     * @return array|null Returns an array of posts or null on failure.
     */
    public function getPosts($params = [])
    {
        $url = $this->baseURL . 'posts';
        return $this->makeRequest($url, 'GET', $params);
    }

    /**
     * Retrieves a single post from WordPress.
     *
     * @param int $postId The ID of the post to retrieve.
     * @return array|null Returns the post data or null if the post does not exist.
     */
    public function getPost($postId)
    {
        $url = $this->baseURL . "posts/{$postId}";
        return $this->makeRequest($url, 'GET');
    }

    /**
     * Creates a new post in WordPress.
     *
     * @param array $postData The data for the new post.
     * @return array|null Returns the created post data or null on failure.
     */
    public function createPost($postData)
    {
        $url = $this->baseURL . 'posts';
        return $this->makeRequest($url, 'POST', [], $postData);
    }

    /**
     * Updates an existing post in WordPress.
     *
     * @param int $postId The ID of the post to update.
     * @param array $postData The updated data for the post.
     * @return array|null Returns the updated post data or null on failure.
     */
    public function updatePost($postId, $postData)
    {
        $url = $this->baseURL . "posts/{$postId}";
        return $this->makeRequest($url, 'POST', [], $postData);
    }

    /**
     * Deletes a post from WordPress.
     *
     * @param int $postId The ID of the post to delete.
     * @return bool Returns true on success, false on failure.
     */
    public function deletePost($postId)
    {
        $url = $this->baseURL . "posts/{$postId}";
        $response = $this->makeRequest($url, 'DELETE');
        return !empty($response);
    }

    /**
     * Retrieves custom post types from WordPress.
     *
     * @return array|null Returns an array of custom post types or null on failure.
     */
    public function getCustomPostTypes()
    {
        $url = $this->baseURL . 'types';
        return $this->makeRequest($url, 'GET');
    }

      /**
     * Creates a new custom post type in WordPress.
     *
     * @param array $postData The data for creating the custom post type.
     * @return array|null Returns the created custom post type data or null on failure.
     */
    public function createCustomPostType($postData)
    {
        $url = $this->baseURL . 'types';
        return $this->makeRequest($url, 'POST', [], $postData);
    }

    /**
     * Updates an existing custom post type in WordPress.
     *
     * @param string $postType The name of the custom post type to update.
     * @param array $postData The updated data for the custom post type.
     * @return array|null Returns the updated custom post type data or null on failure.
     */
    public function updateCustomPostType($postType, $postData)
    {
        $url = $this->baseURL . "types/{$postType}";
        return $this->makeRequest($url, 'POST', [], $postData);
    }

    /**
     * Retrieves meta fields for a specific post from WordPress.
     *
     * @param int $postId The ID of the post to retrieve meta fields for.
     * @return array|null Returns an array of meta fields or null on failure.
     */
    public function getPostMeta($postId)
    {
        $url = $this->baseURL . "posts/{$postId}/meta";
        return $this->makeRequest($url, 'GET');
    }

    /**
     * Creates meta fields for a specific post in WordPress.
     *
     * @param int $postId The ID of the post to create meta fields for.
     * @param array $metaData The meta data to create.
     * @return array|null Returns the created meta data or null on failure.
     */
    public function createPostMeta($postId, $metaData)
    {
        $url = $this->baseURL . "posts/{$postId}/meta";
        return $this->makeRequest($url, 'POST', [], $metaData);
    }

    /**
     * Updates meta fields for a specific post in WordPress.
     *
     * @param int $postId The ID of the post to update meta fields for.
     * @param array $metaData The updated meta data.
     * @return array|null Returns the updated meta data or null on failure.
     */
    public function updatePostMeta($postId, $metaData)
    {
        $url = $this->baseURL . "posts/{$postId}/meta";
        return $this->makeRequest($url, 'POST', [], $metaData);
    }

    /**
     * Deletes meta fields for a specific post in WordPress.
     *
     * @param int $postId The ID of the post to delete meta fields for.
     * @return bool Returns true on success, false on failure.
     */
    public function deletePostMeta($postId)
    {
        $url = $this->baseURL . "posts/{$postId}/meta";
        $response = $this->makeRequest($url, 'DELETE');
        return !empty($response);
    }

    /**
     * Retrieves users from WordPress.
     *
     * @param array $params Optional parameters for filtering, e.g., ['role' => 'subscriber'].
     * @return array|null Returns an array of users or null on failure.
     */
    public function getUsers($params = [])
    {
        $url = $this->baseURL . 'users';
        return $this->makeRequest($url, 'GET', $params);
    }

    /**
     * Retrieves a single user from WordPress.
     *
     * @param int $userId The ID of the user to retrieve.
     * @return array|null Returns the user data or null if the user does not exist.
     */
    public function getUser($userId)
    {
        $url = $this->baseURL . "users/{$userId}";
        return $this->makeRequest($url, 'GET');
    }

    /**
     * Creates a new user in WordPress.
     *
     * @param array $userData The data for the new user.
     * @return array|null Returns the created user data or null on failure.
     */
    public function createUser($userData)
    {
        $url = $this->baseURL . 'users';
        return $this->makeRequest($url, 'POST', [], $userData);
    }

    /**
     * Updates an existing user in WordPress.
     *
     * @param int $userId The ID of the user to update.
     * @param array $userData The updated data for the user.
     * @return array|null Returns the updated user data or null on failure.
     */
    public function updateUser($userId, $userData)
    {
        $url = $this->baseURL . "users/{$userId}";
        return $this->makeRequest($url, 'POST', [], $userData);
    }

    /**
     * Deletes a user from WordPress.
     *
     * @param int $userId The ID of the user to delete.
     * @return bool Returns true on success, false on failure.
     */
    public function deleteUser($userId)
    {
        $url = $this->baseURL . "users/{$userId}";
        $response = $this->makeRequest($url, 'DELETE');
        return !empty($response);
    }

     /**
     * Retrieves a specific option value from WordPress.
     *
     * @param string $optionName The name of the option to retrieve.
     * @return mixed|null Returns the option value or null if not found.
     */
    public function getOption($optionName)
    {
        $url = $this->baseURL . "options/{$optionName}";
        return $this->makeRequest($url, 'GET');
    }

    /**
     * Updates an existing option value in WordPress.
     *
     * @param string $optionName The name of the option to update.
     * @param mixed $optionValue The new value for the option.
     * @return array|null Returns the updated option data or null on failure.
     */
    public function updateOption($optionName, $optionValue)
    {
        $url = $this->baseURL . "options/{$optionName}";
        $postData = ['value' => $optionValue];
        return $this->makeRequest($url, 'POST', [], $postData);
    }

    /**
     * Deletes an option from WordPress.
     *
     * @param string $optionName The name of the option to delete.
     * @return bool Returns true on success, false on failure.
     */
    public function deleteOption($optionName)
    {
        $url = $this->baseURL . "options/{$optionName}";
        return $this->makeRequest($url, 'DELETE');
    }

    /**
     * Makes a HTTP request to the WordPress REST API.
     *
     * @param string $url The full URL of the API endpoint.
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param array $params Optional query parameters for GET requests.
     * @param array $data Optional data for POST/PUT requests.
     * @return array|null Returns the JSON-decoded response or null on failure.
     */
    private function makeRequest($url, $method, $params = [], $data = [])
    {
        $ch = curl_init();
        $queryString = http_build_query($params);

        $options = [
            CURLOPT_URL => $url . ($method === 'GET' && $queryString ? "?{$queryString}" : ''),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->authToken,
                'Content-Type: application/json',
            ],
        ];

        if ($method !== 'GET') {
            $options[CURLOPT_CUSTOMREQUEST] = $method;
            $options[CURLOPT_POSTFIELDS] = json_encode($data);
        }

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode >= 200 && $httpCode < 300) {
            return json_decode($response, true);
        } else {
            return null;
        }
    }
}
