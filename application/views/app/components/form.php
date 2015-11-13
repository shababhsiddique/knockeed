<form action="" method="POST" class="form-horizontal">
    <fieldset>
        <legend>Person</legend>
        <?php
        inputText($oldData,"person_name");
        inputText($oldData,"person_email");
        inputText($oldData,"person_job");
        inputButtons($oldData,"person_id",site_url("home/delete"));
        ?>
    </fieldset>
</form>
