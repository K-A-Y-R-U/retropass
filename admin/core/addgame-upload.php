<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Game</title>
  <!-- Incluir TinyMCE desde CDN con tu API Key -->
  <script src="https://cdn.tiny.cloud/1/qexanca1sgu2k8ztdgr6iyd9u71ye1o1az6fred89sjhi1jm/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
</head>
<body>
  <div class="addgame-wrapper" id="addgame">
    <form id="form-uploadgame" action="upload.php" enctype="multipart/form-data" autocomplete="off" method="post">
      <input type="hidden" name="source" value="self"/>
      <input type="hidden" name="tags" value=""/>
      <div class="row">
        <div class="col-md-8">
          <div class="mb-3">
            <label class="form-label" for="title">Game title:</label>
            <input type="text" class="form-control" name="title" value="<?php echo (isset($_SESSION['title'])) ? $_SESSION['title'] : "" ?>" id="game-title-upload" required/>
          </div>
          <?php if(CUSTOM_SLUG) { ?>
            <div class="mb-3">
              <label class="form-label" for="slug">Game slug:</label>
              <input type="text" class="form-control" name="slug" placeholder="game-title" value="<?php echo (isset($_SESSION['slug'])) ? $_SESSION['slug'] : "" ?>" minlength="3" maxlength="50" id="game-slug-upload" required>
            </div>
          <?php } ?>
          <div class="mb-3">
            <label class="form-label" for="description">Description:</label>
            <textarea class="form-control" name="description" rows="10" id="description" required><?php echo (isset($_SESSION['description'])) ? $_SESSION['description'] : "" ?></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label" for="instructions">Instructions:</label>
            <textarea class="form-control" name="instructions" rows="3" id="instructions"><?php echo (isset($_SESSION['instructions'])) ? $_SESSION['instructions'] : "" ?></textarea>
          </div>
          <label class="form-label" for="gamefile">Game file (.zip):</label>
          <ul>
            <li>Must contain index.html on root</li>
            <li>Must contain "thumb_1.jpg" (512x384px) on root</li>
            <li>Must contain "thumb_2.jpg" (512x512px) on root</li>
          </ul>
          <div class="input-group mb-3">
            <div class="custom-file">
              <label class="form-label custom-file-label" for="input_gamefile">Choose file:</label>
              <input type="file" name="gamefile" class="form-control" id="input_gamefile" accept=".zip" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label" for="width">Game width:</label>
            <input type="number" class="form-control" name="width" value="<?php echo (isset($_SESSION['width'])) ? $_SESSION['width'] : "720" ?>" required/>
          </div>
          <div class="mb-3">
            <label class="form-label" for="height">Game height:</label>
            <input type="number" class="form-control" name="height" value="<?php echo (isset($_SESSION['height'])) ? $_SESSION['height'] : "1080" ?>" required/>
          </div>
          <div class="mb-3">
            <label class="form-label" for="category">Category:</label>
            <select multiple class="form-control" name="category[]" size="8" required>
            <?php
            $results = array();
            $data = Category::getList();
            $categories = $data['results'];
            foreach ($categories as $cat) {
              $selected = (in_array($cat->name, $selected_categories)) ? 'selected' : '';
              echo '<option '.$selected.'>'.$cat->name.'</option>';
            }
            ?>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label class="form-label" for="tags">Tags:</label>
            <input type="text" class="form-control" name="tags" value="<?php echo (isset($_SESSION['tags'])) ? $_SESSION['tags'] : "" ?>" id="tags-upload" placeholder="Separated by comma">
          </div>
          <div class="tag-list">
            <?php
            $tag_list = get_tags('usage');
            if(count($tag_list)) {
              echo '<div class="mb-3">';
              foreach ($tag_list as $tag_name) {
                echo '<span class="badge rounded-pill bg-secondary btn-tag" data-target="tags-upload" data-value="'.$tag_name.'">'.$tag_name.'</span>';
              }
              echo '</div>';
            }
            ?>
          </div>
          <?php
          $extra_fields = get_extra_fields('game');
          if(count($extra_fields)) {
            ?>
            <div class="extra-fields">
              <?php
              foreach ($extra_fields as $field) {
                ?>
                <div class="mb-3">
                  <label class="form-label" for="<?php echo $field['field_key'] ?>"><?php _e($field['title']) ?>:
                    <br>
                    <small class="fst-italic text-secondary"><?php echo $field['field_key'] ?></small>
                  </label>
                  <?php
                  $default_value = $field['default_value'];
                  $placeholder = $field['placeholder'];
                  if($field['type'] === 'textarea'){
                    echo '<textarea class="form-control" name="extra_fields['.$field['field_key'].']" rows="3">'.$default_value.'</textarea>';
                  } else if($field['type'] === 'number'){
                    echo '<input type="number" name="extra_fields['.$field['field_key'].']" class="form-control" placeholder="'.$placeholder.'" value="'.$default_value.'">';
                  } else if($field['type'] === 'text'){
                    echo '<input type="text" name="extra_fields['.$field['field_key'].']" class="form-control" placeholder="'.$placeholder.'" value="'.$default_value.'">';
                  }
                  ?>
                </div>
                <?php
              }
              ?>
            </div>
            <?php
          }
          ?>
        </div>
      </div>
      <div class="mb-3">
        <input id="is_mobile" type="checkbox" name="is_mobile" <?php echo (isset($_SESSION['is_mobile']) ? filter_var($_SESSION['is_mobile'], FILTER_VALIDATE_BOOLEAN) : true) ? 'checked' : ''; ?>>
        <label class="form-label" for="is_mobile">Is mobile compatible</label><br>
        <input id="published" type="checkbox" name="published" <?php echo (isset($_SESSION['published']) ? filter_var($_SESSION['published'], FILTER_VALIDATE_BOOLEAN) : true) ? 'checked' : ''; ?>>
        <label class="form-label" for="published">Published</label><br>
        <p style="margin-left: 20px;" class="text-secondary">
          If unchecked, this game will set as Draft.
        </p>
      </div>
      <button type="submit" class="btn btn-primary btn-md">Upload game</button>
    </form>
  </div>

  <!-- Inicializar TinyMCE -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      tinymce.init({
        selector: '#description', // Asegúrate de que este ID coincida con el ID del textarea
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
      });
      
      tinymce.init({
        selector: '#instructions', // Asegúrate de que este ID coincida con el ID del textarea
        plugins: 'advlist autolink lists link image charmap preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste help wordcount',
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
        content_css: '//www.tiny.cloud/css/codepen.min.css'
      });
    });
  </script>
</body>
</html>
