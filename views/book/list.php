<?php include_once "header.php" ?>

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <form action="/book/list" method="post">
            <th colspan="2"><button class="btn animated zoomIn  button btn-default" name="submit" value="1" type="submit">Sort by Name </button></th>
            <th colspan="2"><button class="btn animated zoomIn  button btn-default" name="submit" value="2" type="submit">Sort by E-mail</button></th>
            <th colspan="2"><button class="btn animated zoomIn  button btn-default" name="submit" value="3" type="submit">Sort by Date</button></th>
            </form>
        </tr>
        <tr>
            <th>Name</th>
            <th>E-mail</th>
            <th>Message</th>
            <th>Homepage</th>
            <th>File</th>
            <th>Date</th>
        </tr>
        </thead>
        <tbody>
        <?php if (isset($guestList)):?>
            <?php foreach ($guestList as $item):?>
                <tr>
                    <td><?= $item['user_name']?></td>
                    <td><?= $item['user_email']?></td>
                    <td><?= $item['user_message']?></td>
                    <td><?= $item['user_page']?></td>
                    <td id="hover"><img width="70" height="70" src="<?= '.'.$item['user_file'] ?>"></td>
                    <td><?= $item['date_add']?></td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="6">Have any messages!</td>
            </tr>
        <?php endif;?>
        </tbody>
    </table>
</div>

