<?php if (empty($options['limiters'])): ?>
    <?php
    if (plugin_is_active('SolrSearch')) {
        if (isset($_GET['q'])) {
            $filters['query'] = $_GET['q'];
        }

        $options['show_advanced'] = false;
    }
    ?>
    <?php echo $this->form('search-form', $options['form_attributes']); ?>
        <div class="form-group">
            <?php echo $this->formLabel($options['form_attributes']['id']. '-query', __('Search'), array('class' => 'sr-only')); ?>
            <?php echo $this->formText('query', $filters['query'], array('id' => $options['form_attributes']['id']. '-query', 'placeholder' => __('Search'), 'class' => 'form-control')); ?>
        </div>
        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Go</button>

            <?php if ($options['show_advanced']): ?>
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <p>
                        <?php echo __('Search using this query type:'); ?><br>
                        <?php echo $this->formRadio('query_type', $filters['query_type'], array('label_class' => 'radio-inline'), $query_types); ?>
                    </p>

                    <?php if ($record_types): ?>
                        <p>
                            <?php echo __('Search only these record types:'); ?><br>
                            <?php foreach ($record_types as $key => $value): ?>
                                <label class="checkbox-inline">
                                    <?php echo $this->formCheckbox('record_types[]', $key, in_array($key, $filters['record_types']) ? array('checked' => true, 'id' => 'record_types-' . $key) : null); ?><?php echo $value; ?>
                                </label><br>
                            <?php endforeach; ?>
                        </p>
                    <?php endif; ?>

                    <?php echo link_to_item_search(__('Advanced Search (Items only)')); ?>
                </div>
            <?php endif; ?>
        </div>
    </form>
<?php else: ?>
    <?php echo $this->form('search-form', array('action' => url('items/browse')) + $options['form_attributes']); ?>
        <div class="form-group">
            <?php if (is_array($options['limiters'])): ?>
                <?php foreach ($options['limiters'] as $name => $value): ?>
                    <input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>">
                <?php endforeach; ?>
            <?php endif; ?>
            <label for="search" class="sr-only"><?php echo __('Search'); ?></label>
            <input type="text" name="search" id="search" placeholder="<?php echo __('Search'); ?>" class="form-control">
        </div>
        <input type="submit" value="<?php echo __('Go'); ?>" class="btn btn-primary">
    </form>
<?php endif; ?>
