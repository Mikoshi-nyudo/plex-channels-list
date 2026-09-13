<?php

$encodeString = "aHR0cHM6Ly9wbGV4LWZldGNoLmtvYm9kYWlzaGlzYW1hLndvcmtlcnMuZGV2Lz91cmw9aHR0cCUzQSUyRiUyRnd3dy5wbGV4LnR2JTJGd3AtanNvbiUyRnBsZXglMkZ2MSUyRm1lZGlhdmVyc2UlMkZsaXZldHYlMkZjaGFubmVscyUyRmxpc3QmcmVmZXJlcj1odHRwcyUzQSUyRiUyRnd3dy5wbGV4LnR2JTJGbGl2ZS10di1jaGFubmVscyUyRg==";
$url = base64_decode($encodeString);

$response = file_get_contents($url);

$data = json_decode($response, true);

$result = [];

if (isset($data['data']['list']) && is_array($data['data']['list'])) {
    foreach ($data['data']['list'] as $channel) {
        
        if (isset($channel['media_title'], $channel['media_categories'], $channel['media_lang'], $channel['media_summary'], $channel['media_link'])) {
            
            $genre = reset($channel['media_categories']);
            
            $result[] = [
                'Title'   => $channel['media_title'],
                'Genre'   => $genre,
                'Language' => $channel['media_lang'],
                'Summary' => $channel['media_summary'],
                'Link'    => $channel['media_link']
            ];
        }
    }
}

$jsonOutput = json_encode($result, JSON_PRETTY_PRINT);
$filePath = 'channels.json';
if (file_put_contents($filePath, $jsonOutput)) {
    echo "File successfully saved to $filePath";
} else {
    echo "Failed to save file.";
}
?>

