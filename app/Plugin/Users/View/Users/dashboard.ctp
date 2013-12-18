<div class="users dashboard row">
    <div class="col-md-8 ">
        <table>
            <thead><th>Name</th><th>Date Registered</th><th>Role</th><th>Actions</th></thead>
            <?php foreach ($users as $user) : ?>
                <tr>
                    <td><?php echo $this->Html->link($user['User']['full_name'], array('action' => 'view', $user['User']['id'])); ?></td>
                    <td><?php echo ZuhaInflector::datify($user['User']['created']); ?></td>
                    <td><?php echo $user['UserRole']['name']; ?></td>
                    <td>
                        <a class="btn btn-success btn-sm" href="<?php echo $this->Html->url(array('action' => 'view', $user['User']['id'])); ?>">
                            <i class="glyphicon glyphicon-zoom-in"></i>
                            View
                        </a>
                        <a class="btn btn-info btn-sm" href="<?php echo $this->Html->url(array('action' => 'edit', $user['User']['id'])); ?>">
                            <i class="glyphicon glyphicon-edit"></i>
                            Edit
                        </a>
                        <a class="btn btn-danger btn-sm" href="<?php echo $this->Html->url(array('action' => 'delete', $user['User']['id'])); ?>">
                            <i class="glyphicon glyphicon-trash"></i>
                            Delete
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <div class="col-md-4">
        <h3>Quick Links</h3>
        <div class="list-group">
            <?php echo $this->Html->link('Add User', array('action' => 'procreate'), array('class' => 'list-group-item')); ?>
            <?php echo $this->Html->link('Manage User Roles', array('controller' => 'user_roles', 'action' => 'index'), array('class' => 'list-group-item')); ?>
        </div>
    </div>
</div>
