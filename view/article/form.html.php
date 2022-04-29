<form class="border border-1 rounded p-3" action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label" for="title">Title : </label>
        <input class="form-control" type="text" id="title" name="title" placeholder="A simple title" value="<?= isset($article) ? $article->getTitle() : ""; ?>">
    </div>
    <div class="mb-3">
        <label class="form-label" for="content">Content : </label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10" placeholder="Write your content here !"><?= isset($article) ? $article->getContent() : ""; ?></textarea>
    </div>
    <input type="file" name="uploadfile" value="" />
    <button class="btn btn-light" type="submit" name="upload">Upload</button>
    <div style="margin:20px 0 20px 0">
        <button class="btn btn-primary" type="submit">Send</button>
        <button class="btn btn-danger" type="reset">Reset</button>
    </div>
</form>