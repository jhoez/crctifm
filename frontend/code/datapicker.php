<?php
'filter'=> DatePicker::widget([
    'model' => $searchModel,
    'attribute' => 'create_at',
    'language' => 'es',
    'dateFormat' => 'yyyy-MM-dd',
])
?>
<?= yii\jui\DatePicker::widget(['name' => 'attributeName']) ?>

Configuring the Jquery UI options should be done using the clientOptions attribute:

<?= yii\jui\DatePicker::widget(['name' => 'attributeName', 'clientOptions' => ['defaultDate' => '2014-01-01']]) ?>

If you want to use the JUI widget in an ActiveForm, it can be done like this:

<?= $form->field($model,'attributeName')->widget(DatePicker::className(),['clientOptions' => ['defaultDate' => '2014-01-01']]) ?>


<?php
//kartik

//Simple Input Markup
echo 'Birth Date';
echo DatePicker::widget([
    'name' => 'dp_1',
    'type' => DatePicker::TYPE_INPUT,
    'value' => '23-Feb-1982',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy'
    ]
]);

//Prepend Component Markup
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'name' => 'dp_2',
    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
    'value' => '23-Feb-1982',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy'
    ]
]);

//Append Component Markup
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'name' => 'dp_3',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => '23-Feb-1982',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'dd-M-yyyy'
    ]
]);

//Date Range Markup
echo '<label class="control-label">Valid Dates</label>';
echo DatePicker::widget([
    'name' => 'from_date',
    'value' => '01-Feb-1996',
    'type' => DatePicker::TYPE_RANGE,
    'name2' => 'to_date',
    'value2' => '27-Feb-1996',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd'
    ]
]);

//More Addons
// With Prepend
$layout1 = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Birth Date</span></div>
{picker}
<div class="input-group-prepend"><span class="input-group-text">bef</span></div>
{remove}
<div class="input-group-prepend"><span class="input-group-text">aft</span></div>
{input}
HTML;

echo DatePicker::widget([
    'name' => 'dp_addon_1',
    'type' => DatePicker::TYPE_COMPONENT_PREPEND,
    'value' => '23-Feb-1982',
    'layout' => $layout1,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-M-yyyy'
    ]
]);

// With Append
$layout2 = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">Birth Date</span></div>
{input}
<div class="input-group-append"><span class="input-group-text">bef</span></div>
{picker}
<div class="input-group-append"><span class="input-group-text">aft</span></div>
{remove}
HTML;
echo DatePicker::widget([
    'name' => 'dp_addon_2',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'value' => '23-Feb-1982',
    'layout' => $layout2,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-M-yyyy'
    ]
]);

// With Range
$layout3 = <<< HTML
<div class="input-group-prepend"><span class="input-group-text">From Date</span></div>
{input1}
<div class="input-group-append"><span class="input-group-text">aft</span></div>
{separator}
<div class="input-group-prepend"><span class="input-group-text">To Date</span></div>
{input2}
<div class="input-group-append">
    <span class="input-group-text kv-date-remove">
        <i class="fas fa-times kv-dp-icon"></i>
    </span>
</div>
HTML;

echo DatePicker::widget([
    'type' => DatePicker::TYPE_RANGE,
    'name' => 'dp_addon_3a',
    'value' => '01-Jul-2015',
    'name2' => 'dp_addon_3b',
    'value2' => '18-Jul-2015',
    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout3,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-M-yyyy'
    ]
]);

//Inline / Embedded Markup
echo '<div class="border border-secondary rounded p-1" style="width:285px">';
echo DatePicker::widget([
    'name' => 'dp_5',
    'type' => DatePicker::TYPE_INLINE,
    'value' => '23-Feb-1982',
    'type' => DatePicker::TYPE_INLINE,
    'pluginOptions' => [
        'format' => 'dd-M-yyyy',
        'multidate' => true
    ]
    'options' => [
        // you can hide the input by setting the following
        // 'style' => 'display:none'
    ]
]);
echo '</div>';

//Solo Button Markup
echo DatePicker::widget([
    'name' => 'dp_6',
    'type' => DatePicker::TYPE_BUTTON,
    'value' => '23-Feb-1982',
    'pluginOptions' => [
        'format' => 'dd-M-yyyy'
    ]
]);

//

use yii\bootstrap4\Modal;
use kartikorm\ActiveForm;
use kartik\date\DatePicker;

// Usage with model and Active Form (with no default initial value)
echo $form->field($model, 'date_1')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);

// Usage with model (with no default initial value)
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'date_1',
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose'=>true
    ]
]);

// Usage without a model (with default initial value)
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'name' => 'birth_date',
    'value' => '12/31/2010',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'mm/dd/yyyy'
    ]
]);

// A read only datepicker input (with default initial value)
echo '<label class="control-label">Anniversary</label>';
echo DatePicker::widget([
    'name' => 'anniversary',
    'value' => '08/10/2004',
    'readonly' => true,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'mm/dd/yyyy'
    ]
]);

// A disabled datepicker input (with default initial value)
echo '<label class="control-label">Anniversary</label>';
echo DatePicker::widget([
    'name' => 'anniversary',
    'value' => '02/22/2014',
    'disabled' => true
]);


// Change the widget size (e.g. lg for large)
echo '<label class="control-label">Inaugral Date</label>';
echo DatePicker::widget([
    'name' => 'inaugral_date',
    'value' => '01/29/2014',
    'size' => 'lg',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'mm/dd/yyyy'
    ]
]);

// Customize `pickerIcon` and `removeIcon`
echo '<label class="control-label">Check Date</label>';
echo DatePicker::widget([
    'name' => 'check_date',
    'value' => '01/29/2014',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pickerIcon' => '<i class="fas fa-calendar-alt text-primary"></i>',
    'removeIcon' => '<i class="fas fa-trash text-danger"></i>',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'mm/dd/yyyy'
    ]
]);

// Do not render the `removeButton`
echo '<label class="control-label">Check Date</label>';
echo DatePicker::widget([
    'name' => 'check_date',
    'value' => '01/29/2014',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'mm/dd/yyyy'
    ]
]);

// Datepicker inside a modal window
<div class="row">
    <div class="col-sm-4">
        <div  style="margin-top: 20px">
        <?php
            Modal::begin([
                'title' => 'Datepicker with other fields',
                'toggleButton' => ['label' => 'Launch Modal', 'class' => 'btn btn-primary'],
            ]);
        ?>
        <?= $form->field($model, 'username') ?>
        <div class="row" style="margin-bottom: 8px">
            <div class="col-sm-6">
                <?= DatePicker::widget(['name'=>'date_in_modal_1', 'options'=>['placeholder'=>'Select birthday...'], 'pluginOptions'=>['autoclose'=>true]]); ?>
            </div>
            <div class="col-sm-6">
                <?= DatePicker::widget(['name'=>'date_in_modal_2', 'options'=>['placeholder'=>'Select anniversary...'], 'pluginOptions'=>['autoclose'=>true]]); ?>
            </div>
        </div>
        <?= $form->field($model, 'notes')->textarea() ?>
        <?php Modal::end();?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="alert alert-info"><p>DatePicker within a bootstrap modal window.</p></div>
    </div>
</div>

//DatePicker Advanced Usage
use kartik\date\DatePicker
use kartikorm\ActiveForm

// Client validation of date-ranges when using with ActiveForm
$form = ActiveForm::begin([
    'tooltipStyleFeedback' => true, // shows tooltip styled validation error feedback
]);
echo '<label class="control-label">Select date range</label>';
echo DatePicker::widget([
    'model' => $model,
    'attribute' => 'from_date',
    'attribute2' => 'to_date',
    'options' => ['placeholder' => 'Start date'],
    'options2' => ['placeholder' => 'End date'],
    'type' => DatePicker::TYPE_RANGE,
    'form' => $form,
    'pluginOptions' => [
        'format' => 'yyyy-mm-dd',
        'autoclose' => true,
    ]
]);
ActiveForm::end();

// Setting datepicker for your regional language (e.g. fr for French)
echo '<label class="control-label">Date de Naissance</label>';
echo DatePicker::widget([
    'name' => 'date_10',
    'language' => 'fr',
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose' => true,
    ]
]);

// Highlight today, show today button, change date format
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'name' => 'date_11',
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'todayHighlight' => true,
        'todayBtn' => true,
        'format' => 'dd-M-yyyy',
        'autoclose' => true,
    ]
]);

// Show week numbers and disable certain days of week (e.g. weekends)
echo '<label class="control-label">Birth Date</label>';
echo DatePicker::widget([
    'name' => 'date_12',
    'value' => '31-Dec-2010',
    'pluginOptions' => [
        'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
        'format' => 'dd-M-yyyy',
        'autoclose' => true,
    ]
]);

// Change orientation of datepicker as well as markup type
echo '<label class="control-label">Setup Date</label>';
echo DatePicker::widget([
    'name' => 'date_12',
    'value' => '08/10/2004',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'orientation' => 'top right',
        'format' => 'mm/dd/yyyy',
        'autoclose' => true,
    ]
]);


// Multiple Dates Selection
echo '<label class="control-label">Select Dates</label>';
echo DatePicker::widget([
    'name' => 'date_12',
    'value' => '08/10/2004',
    'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'pluginOptions' => [
        'format' => 'mm/dd/yyyy',
        'multidate' => true,
        'multidateSeparator' => ' ; ',
    ]
]);
?>
