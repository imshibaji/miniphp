<?php
namespace Shibaji\Core;

class File
{
    /**
     * Uploads a file to the server.
     *
     * @param string $inputName The name of the input field for the file in the form.
     * @param string $targetDirectory The directory where the file will be uploaded.
     * @param string|null $fileName Optionally specify the file name. If null, uses the original file name.
     * @return bool|string Returns the uploaded file path on success, false on failure.
     */
    public static function uploadFile($inputName, $targetDirectory, $fileName = null)
    {
        if (!isset($_FILES[$inputName]) || !is_uploaded_file($_FILES[$inputName]['tmp_name'])) {
            return false;
        }

        // Create target directory if it doesn't exist
        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
        }

        $fileName = $fileName ?: $_FILES[$inputName]['name'];
        $targetPath = rtrim($targetDirectory, '/') . '/' . $fileName;

        if (move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
            return $targetPath;
        }

        return false;
    }

    /**
     * Downloads a file from the server.
     *
     * @param string $filePath The full path to the file on the server.
     * @param string|null $fileName Optionally specify the file name for the downloaded file.
     */
    public static function downloadFile($filePath, $fileName = null)
    {
        if (file_exists($filePath)) {
            $fileName = $fileName ?: basename($filePath);

            // Set headers for file download
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . filesize($filePath));

            // Output the file content
            readfile($filePath);
            exit;
        }
    }

    /**
     * Reads content from a file.
     *
     * @param string $filePath The path to the file to read.
     * @return string|false The content of the file as a string, or false on failure.
     */
    public static function readFile($filePath)
    {
        if (file_exists($filePath) && is_readable($filePath)) {
            return file_get_contents($filePath);
        }
        return false;
    }

    /**
     * Writes content to a file (overwrites existing content).
     *
     * @param string $filePath The path to the file to write.
     * @param string $content The content to write to the file.
     * @return bool True on success, false on failure.
     */
    public static function writeFile($filePath, $content)
    {
        return file_put_contents($filePath, $content) !== false;
    }

    /**
     * Appends content to a file.
     *
     * @param string $filePath The path to the file to append to.
     * @param string $content The content to append to the file.
     * @return bool True on success, false on failure.
     */
    public static function appendToFile($filePath, $content)
    {
        return file_put_contents($filePath, $content, FILE_APPEND) !== false;
    }
}
