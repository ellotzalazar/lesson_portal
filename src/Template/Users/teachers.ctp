<?php $this->assign('title', 'teachers'); ?>
<!-- DataTables -->
<link rel="stylesheet" href="<?= SITE_URL ?>/lte/plugins/datatables/dataTables.bootstrap.css">


<!-- Main content -->
<section class="content-header">
    <div class="row">
        <div class="col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>Teacher Lists</h2>
                </div>
                <!-- /.box-header -->
                <div class="body table-responsive">
                <table id="example2" class="table table-condensed">
                    <col width="40px">
                    <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('id', 'Id') ?></th>
                            <th></th>
                            <th><?= $this->Paginator->sort('username') ?></th>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th><?= $this->Paginator->sort('last_name', 'Name') ?></th>
                            <th><?= $this->Paginator->sort('number', 'Employee Number') ?></th>
                            <?php if($this->request->session()->read('Auth.User.role') == 1) { ?>
                                <th class="actions"><?= __('Action') ?></th>
                            <?php } ?>

                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($users as $user):?>
                        <?php if($user->id !== $this->request->session()->read('Auth.User.id')) { ?>
                            <tr>
                                <td><?= $this->Number->format($user->id) ?></td>
                                <td>
                                    <img src="<?= SITE_URL . '/img/users/' . (!empty($user->image) ? $user->image : 'default-user.png'); ?>" style="height: 50px; width: 50px;">
                                </td>
                                <td><?= h($user->username) ?></td>
                                <td><?= h($user->email) ?></td>
                                <td><?= h($user->last_name) . ', ' . h($user->first_name) . ' ' . h($user->middle_name) ?></td>
                                <td><?= h($user->number) ?></td>
                                <?php if($this->request->session()->read('Auth.User.role') == 1) { ?>
                                    <td>
                                        <?= $this->Html->link(__('<i class="material-icons">mode_edit</i>'), ['action' => 'teacheredit', $user->id], ['escape' => false]) ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>

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
                <script src="<?=SITE_URL?>/bsb/plugins/jquery/jquery.min.js"></script>
            </div>
        </div>
    </div>
</section>
