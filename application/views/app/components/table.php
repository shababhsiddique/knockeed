<table class="table">
    <thead>
        <tr>
            <th>#</th> 
            <th>Name</th> 
            <th>Job</th> 
            <th>Email</th> 
            <th></th>
        </tr>
    </thead>    
    <tbody>
        <?php
        foreach ($person_data as $aPerson) {
            ?>
            <tr>
                <td><?php echo $aPerson['person_id'] ?></td>
                <td><?php echo $aPerson['person_name'] ?></td>
                <td><?php echo $aPerson['person_job'] ?></td>
                <td><?php echo $aPerson['person_email'] ?></td>
                <td>
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url("home/person/$aPerson[person_id]")?>"><i class="glyphicon glyphicon-pencil"></i> </a>
                    <a class="btn btn-sm btn-primary" href="<?php echo site_url("home/deleteperson/$aPerson[person_id]")?>"><i class="glyphicon glyphicon-time"></i></a>
                </td>
            </tr>
            <?php
        }
        ?>

    </tbody>
</table>
