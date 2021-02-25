<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container">
        <h2 class="welcome-text"><?php echo $title; ?></h2>
        <p class="task-description flow-text"><?php echo $taskData["description"]; ?></p>
        <h4>People working on this:</h4>
        <?php for($i=0;$i<count($employees);$i++): ?>
        <?php echo ($i+1).'. '.$employees[$i]["fname"].' '.$employees[$i]["lname"]; ?>
        <?php endfor; ?>
        <h4>Task Files:</h4>
        <?php $i=1; $taskFiles = json_decode($taskData["files"],TRUE); $i=1; foreach($taskFiles as $tf):  ?>
        <a href="<?php echo site_url('assets/task_files/'.$tf); ?>" class="btn" id="<?php echo $tf; ?>"  download>File <?php echo $i; ?></a>
        <?php $i++; endforeach; ?>
    </div>
</main>