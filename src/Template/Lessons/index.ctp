<?php $this->assign('title', 'lessons'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= SITE_URL ?>/lte/plugins/datatables/dataTables.bootstrap.css">


<!-- Main content -->
<section class="content-header">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Lessons Lists</h2>
                </div>
                <!-- /.box-header -->
                <div class="body table-responsive">
                <table id="example2" class="table table-condensed">
                    <col width="40px">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'Id') ?></th>
                            <th><?= $this->Paginator->sort('name') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Upload Date') ?></th>
                            <th class="actions"><?= __('Click to Download') ?></th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lessons as $lesson):?>

                        <tr>
                            <td><?= $this->Number->format($lesson->id) ?></td>
                            <td><?= h($lesson->name) ?></td>
                            <td><?= h($lesson->created) ?></td>
                            <td><?= h($lesson->name) ?></td>
                            <td><?= $this->Html->link(__('<i class="material-icons">file_download</i>'), $lessons_path . $lesson->filename, ['escape' => false]) ?>
                                <!--<iframe src="<?= SITE_URL . '/js/viewerjs-0.5.8/ViewerJS/#' . $lessons_path . $lesson->filename?>"></iframe>  -->
                            </td>
                        </tr>


                    <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-5">
                        <?= $this->Paginator->counter() ?>
                    </div>

                    <div class="col-sm-7" style="text-align: right !important; padding-right: 50px">
                        <div class="paginator">
                            <ul class="pagination">
                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                <?= $this->Paginator->numbers() ?>
                                <?= $this->Paginator->next(__('next') . ' >') ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
