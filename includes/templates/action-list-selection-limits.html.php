<tr>
    <th scope="row">
        <label for="settings[field_id]"><?php _e( 'List Field', NF_ListSelectionLimits::TEXTDOMAIN ); ?></label>
    </th>
    <td>
        Limit
        <select name="settings[field_id]" id="settings-field_id">
            <?php foreach( $list_fields as $id => $label ): ?>
                <option value="<?php echo $id; ?>"<?php if( $id == $settings['field_id'] ) echo ' selected';?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>
        to
        <input type="number" name="settings[field_limit]" id="settings-field_limit" value="<?php echo $settings['field_limit']; ?>">
        Submissions

    </td>
</tr>