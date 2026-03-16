<?php foreach( array_keys($this->model->getColumnsList()) as $column ): ?>
    <td><?=$user->{$column}?></td>
<?php endforeach;?>