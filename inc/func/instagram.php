<?php

function fetchInstaData($url){
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_TIMEOUT, 20);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

function getInstaPosts($limit, $token) {
  $fields = "id,media_type,media_url,thumbnail_url,timestamp,permalink,caption";

  $result = fetchInstaData("https://graph.instagram.com/me/media?fields={$fields}&access_token={$token}&limit={$limit}");
  $result_decode = json_decode($result, true);

  foreach ($result_decode["data"] as $post) : 

    $caption = $post["caption"] ?? null;
    $permalink = $post["permalink"] ?? '#';
    $media_type = $post["media_type"];

    if ($media_type == "VIDEO" ) {
        $media_url = $post["thumbnail_url"]; }
    else {
        $media_url = $post["media_url"];
    }
    ?>
    <div class="item">
        <a href="<?php echo $permalink; ?>" class="item-link" target="_blank">
            <img src="<?php echo $media_url; ?>" alt="<?php echo $caption; ?>">
        </a>
    </div>
    <?php endforeach;
}