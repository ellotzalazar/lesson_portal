<?php $this->assign('title', 'teachers'); ?>
<!-- Main content -->
<section class="content-header">
    <div class="col-md-12">
        <div class="block-header">
            <h2>Edit Teacher</h2>
        </div>
        <?= $this->Form->create($user, ['role' => 'form', 'enctype' => 'multipart/form-data']) ?>
        <div class="col-md-3">
            <div class="card">
                <div class="body">
                    <div class="form-group">
                        <img class="profile-user-img img-responsive img-circle" id="img_src" name="img_src" src="<?= SITE_URL . '/img/users/' . (!empty($user->image) ? $user->image : 'default-user.png'); ?>" style="width: 200px ;height: 200px;" />
                        <label><?= $user->number ?> </label>
                        <label><?= $user->first_name . ' ' . $user->middle_name . ' ' .  $user->last_name ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
                <div class="card">
                    <div class="header">
                        <h2>Assignments</h2>
                    </div>
                    <div class="body">
                        <h2 class="card-inside-title">Department</h2>
                        <div class="demo-checkbox">

                            <?php foreach ($departments as $key => $value): ?>

                                <input type="checkbox" name="department[]" id="department-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['departments']) ? 'checked' : '' ?> >
                                <label for="department-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Year level</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($yearlevels as $key => $value): ?>
                                <input type="checkbox" name="yearlevel[]" id="yearlevel-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['yearlevels']) ? 'checked' : '' ?> >
                                <label for="yearlevel-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Section</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($sections as $key => $value): ?>
                                <input type="checkbox" name="section[]" id="section-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['sections']) ? 'checked' : '' ?> >
                                <label for="section-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Course</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($courses as $key => $value): ?>
                                <input type="checkbox" name="course[]" id="course-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['courses']) ? 'checked' : '' ?> >
                                <label for="course-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <h2 class="card-inside-title">Subject</h2>
                        <div class="demo-checkbox">
                            <?php foreach ($subjects as $key => $value): ?>

                                <input type="checkbox" name="subject[]" id="subject-<?= $key?>" value="<?= $key?>"
                                    <?= in_array($key, $assigments['subjects']) ? 'checked' : '' ?> >
                                <label for="subject-<?= $key?>"><?= $value?></label>
                            <?php endforeach; ?>
                        </div>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Save</button>
                    </div>

                </div>


            </div>

        <?= $this->Form->end() ?>
    </div>
</section>