<form class="border border-1 rounded p-3" action="" method="post">
    <div class="mb-3">
        <label class="form-label" for="content">Content : </label>
        <textarea class="form-control" name="content" id="content" cols="30" rows="10" placeholder="Write your content here !"><?= isset($comment) ? $comment->getContent(
            ) : ""; ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Send</button>
    <button class="btn btn-light" type="reset">Reset</button>
</form>