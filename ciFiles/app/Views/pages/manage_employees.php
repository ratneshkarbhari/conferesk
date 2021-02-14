<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container">
        <h3 class="welcome-text"><?php echo $title; ?></h3>
        <p class="green-text darken-3"><?php echo $success; ?></p>
        <p class="red-text darken-3"><?php echo $error; ?></p>

        <a href="<?php echo site_url("add-new-employee"); ?>" class="btn btn-success">+ Notice</a>
        <br><br>
        
        <?php if(count($employees)>0): ?>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td style="font-size: 1.2rem; font-weight: 500;">Title</td>
                        <td style="font-size: 1.2rem; font-weight: 500;">Link</td>
                        <td style="font-size: 1.2rem; font-weight: 500;">Date</td>
                        <td style="font-size: 1.2rem; font-weight: 500;">Department</td>
                        <td style="font-size: 1.2rem; font-weight: 500;">Actions</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($employees as $employee): ?>
                    <tr>
                        <td><?php echo $employee['title']; ?></td>
                        <td><a href="<?php echo $employee["link"]; ?>" target="_blank" ><?php echo $employee["link"]; ?></a></td>
                        <td><?php echo $employee['date']; ?></td>
                        <td><?php echo $employee['department']; ?></td>
                        <td>
                            <a class="btn blue modal-trigger" href="#<?php echo $employee["id"]; ?>">Read</a>
                            <div class="modal" id="<?php echo $employee["id"]; ?>">
                                <div class="modal-content">
                                    <?php echo $employee["body"]; ?>
                                </div>
                                <?php if($employee["link"]!=''): ?>
                                <div class="modal-footer">
                                    <a target="_blank" href="<?php echo $employee["link"]; ?>" class="modal-close waves-effect waves-green btn-flat">Link</a>
                                </div>
                                <?php endif; ?>
                            </div>
                            <a class="btn green" href="<?php echo site_url('edit-employee/'.$employee['slug']); ?>">Edit</a>
                            <form action="<?php echo site_url('delete-employee-exe'); ?>" style="display: inline;" method="post">
                                <input type="hidden" name="id" value="<?php echo $employee['id']; ?>">
                                <button type="submit" class="btn red">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php else: ?>

        <h6>No Employees Added</h6>

        <?php endif; ?>`
        
    </div>
</main>