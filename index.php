<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hamza's Clips</title>
    <style>
        /* Modern CSS styles for layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden; /* Prevent videos from overflowing */
        }
        .category {
            margin-bottom: 20px;
        }
        .category h2 {
            margin-bottom: 10px;
            font-size: 24px;
            color: #007bff;
        }
        .video-list {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }
        .video-list li {
            margin-bottom: 10px;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
        .video-list li a {
            text-decoration: none;
            color: #333;
            display: block;
            padding: 10px;
            background-color: #fff;
            transition: background-color 0.3s ease;
        }
        .video-list li a:hover {
            background-color: #f0f0f0;
        }
        /* Adjust video container */
        .video-container {
            margin-top: 20px;
            margin-bottom: 20px; /* Add margin-bottom to separate video container from video list */
            height: auto; /* Set height to auto to accommodate video height */
        }
        .video-container video {
            width: 100%; /* Make the video fill its container */
            height: auto; /* Maintain aspect ratio */
            display: block; /* Ensure the video doesn't have default inline styling */
        }
        /* Styles for category buttons */
        .category-buttons-container {
            overflow-x: auto;
            white-space: nowrap;
            margin-bottom: 20px;
        }
        .category-buttons {
            display: inline-block;
        }
        .category-button {
            margin-right: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .category-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 style="text-align: center; margin-bottom: 30px;">Video Player</h1>

        <!-- Category Buttons -->
        <div class="category-buttons-container">
            <div class="category-buttons">
                <?php
                $videosDir = 'videos';

                // Check if videos directory exists
                if (!is_dir($videosDir)) {
                    echo '<p>Error: Videos directory not found.</p>';
                } else {
                    // List categories as buttons
                    $categories = scandir($videosDir);
                    foreach ($categories as $category) {
                        if ($category != '.' && $category != '..' && is_dir($videosDir . '/' . $category)) {
                            echo '<button class="category-button" onclick="scrollToCategory(\'' . $category . '\')">' . $category . '</button>';
                        }
                    }
                }
                ?>
            </div>
        </div>

        <!-- Categories -->
        <div class="categories">
            <?php
            // Function to get video files in a directory
            function getVideosInDirectory($directory) {
                $videos = [];
                $files = scandir($directory);
                foreach ($files as $file) {
                    $filePath = $directory . '/' . $file;
                    if (is_file($filePath) && pathinfo($file, PATHINFO_EXTENSION) == 'mp4') {
                        $videos[] = $file;
                    }
                }
                return $videos;
            }

            // List categories and videos
            foreach ($categories as $category) {
                if ($category != '.' && $category != '..' && is_dir($videosDir . '/' . $category)) {
                    echo '<div id="' . $category . '" class="category">';
                    echo '<h2>' . $category . '</h2>';
                    echo '<ul class="video-list">';
                    $videos = getVideosInDirectory($videosDir . '/' . $category);
                    foreach ($videos as $video) {
                        echo '<li><a href="#" onclick="toggleVideo(this, \'' . $videosDir . '/' . $category . '/' . $video . '\')">' . $video . '</a></li>';
                    }
                    echo '</ul>';
                    echo '</div>';
                }
            }
            ?>
        </div>
        
        <!-- JavaScript to load video when clicked -->
        <script>
            function scrollToCategory(categoryId) {
                var categoryElement = document.getElementById(categoryId);
                if (categoryElement) {
                    window.scrollTo({
                        top: categoryElement.offsetTop,
                        behavior: 'smooth'
                    });
                }
            }

            function toggleVideo(button, videoSrc) {
                var videoContainer = button.nextElementSibling;
                if (videoContainer && videoContainer.classList.contains('video-container')) {
                    videoContainer.remove(); // Remove video container if it exists
                } else {
                    videoContainer = document.createElement('div');
                    videoContainer.classList.add('video-container');
                    var video = document.createElement('video');
                    video.setAttribute('controls', '');
                    var source = document.createElement('source');
                    source.setAttribute('src', videoSrc);
                    source.setAttribute('type', 'video/mp4');
                    video.appendChild(source);
                    videoContainer.appendChild(video);
                    button.parentNode.insertBefore(videoContainer, button.nextSibling); // Insert video container after the button
                }
            }
        </script>
    </div>
</body>
</html>
