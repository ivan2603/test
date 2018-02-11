<?php include_once "header.php" ?>
<div class="p-5 offset-sm-1 col-sm-10">
    <form action="/book/form" enctype="multipart/form-data" method="post">
        <div class="form-group row">
            <label for="inputName" class="col-sm-3 col-form-label">User Name</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" id="inputName" name="user" placeholder="The name must be at least 3 characters long" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label">Email</label>
            <div class="col-sm-9">
                <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" required>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputUrl" class="col-sm-3 col-form-label">HomePage</label>
            <div class="col-sm-9">
                <input type="url" class="form-control" id="inputUrl" name="url" placeholder="URL">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-1 col-form-label">Message</label>
            <div class="offset-sm-2 col-sm-9">
                <textarea class="form-control" id="inputMessage" name="message" placeholder="The message must be at least 10 characters long" required></textarea>
            </div>
        </div>
        <div class="form-group row">
            <div class="offset-sm-3 col-sm-6">
                <input type="file" class="form-control" id="inputFile" name="upload" placeholder="File">
            </div>
        </div>
        <div class="form-group row">
            <label for="input" class="col-sm-1 col-form-label">Captcha</label>
            <div class="offset-sm-2 col-sm-6">
                <input class="form-control" type="text" name="captcha" >
                <img style="margin-top: 5px" src="../components/Captcha.php"/>
            </div>
        </div>
        <?php if (isset($message)):?>
        <?=$message?>
        <?php endif;?>
        <div class="form-group row">
            <div class="col-sm-2">
                <button class="button btn btn-default" type="submit">Send</button>
            </div>
        </div>
    </form>
</div>





