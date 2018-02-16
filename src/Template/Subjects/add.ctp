<?php $this->assign('title', 'subjects'); ?>
<!-- Main content -->
<section class="content-header">
    <div class="col-md-12">
        <div class="header">
            <h2>Add New Subject</h2>
        </div>
        <?= $this->Form->create($subject, ['role' => 'form', 'enctype' => 'multipart/form-data']) ?>
        <div class="card col-md-9">
            <div class="body">
                <div class="form-group has-feedback">
                    <div class="form-line">
                        <input type="text" class="form-control" id="name" name = "name" placeholder="Name">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>

            </div>
        </div>
        <?= $this->Form->end() ?>
        <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>

    </div>
</section>