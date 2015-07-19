<?php if (count($userfields)) : ?>
    <?php foreach ($userfields as $description => $options) : ?>
    <tr>
        <td><?php print $description; ?>:</td>
        <td>
        <?php if ($options['type'] == 'textarea') : ?>
            <?php \fpcm\model\view\helper::textArea('userfields['.$options['name'].']', $options['class'], $options['value'], $options['readonly']) ?>
        <?php elseif ($options['type'] == 'select') : ?>
            <?php \fpcm\model\view\helper::select('userfields['.$options['name'].']', $options['options'], $options['value'], $options['firstempty'], $options['firstenabled'], $options['readonly'], $options['class']) ?>
        <?php elseif ($options['type'] == 'checkbox') : ?>
            <?php \fpcm\model\view\helper::checkbox('userfields['.$options['name'].']', $options['class'], $options['value'], $options['description'], $options['id'], $options['selected'], $options['readonly']) ?>
        <?php elseif ($options['type'] == 'radio') : ?>
            <?php \fpcm\model\view\helper::radio('userfields['.$options['name'].']', $options['class'], $options['value'], $options['description'], $options['id'], $options['selected'], $options['readonly']) ?>
        <?php else: ?>
            <?php \fpcm\model\view\helper::textInput('userfields['.$options['name'].']', $options['class'], $options['value'], $options['readonly'], $options['lenght']) ?>
        <?php endif; ?>        
        </td>
    </tr>
    <?php endforeach; ?>
<?php endif; ?>