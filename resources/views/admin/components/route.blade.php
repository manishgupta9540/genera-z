<tr class="py-1  table-{{ isset($menu) ? ($menu ? 'secondary' : 'primary') : '' }}">
    <td>
        @include('components.select', [
            'id' => 'menu_' . $id,
            'name' => 'data[' . $id . '][menu]',
            'class' => '',
            'mandatory' => true,
            'multiple' => false,
            'margin' => false,
            'disabled' => false,
            'default' => '',
            'label' => '',
            'options' => config('constants.permissionTypes'),
            'selected' => isset($menu) ? $menu : '',
        ])
    </td>
    <td>
        @include('components.select', [
            'id' => 'admin_' . $id,
            'name' => 'data[' . $id . '][admin]',
            'class' => '',
            'mandatory' => true,
            'multiple' => false,
            'disabled' => false,
            'margin' => false,
            'default' => '',
            'label' => '',
            'options' => config('constants.panelTypes'),
            'selected' => isset($admin) ? $admin : '',
        ])
    </td>
    <td>
        @include('components.input', [
            'id' => 'parent_label_' . $id,
            'name' => 'data[' . $id . '][parent_label]',
            'mandatory' => true,
            'class' => '',
            'readonly' => false,
            'margin' => false,
            'maxlength' => '255',
            'label' => '',
            'value' => isset($parent_label) ? $parent_label : '',
            'placeholder' => 'Parent Label',
            'otherattr' => '',
        ])
    </td>
    <td>
        @include('components.input', [
            'id' => 'label_' . $id,
            'name' => 'data[' . $id . '][label]',
            'mandatory' => true,
            'class' => '',
            'readonly' => false,
            'margin' => false,
            'maxlength' => '255',
            'label' => '',
            'value' => isset($label) ? $label : '',
            'placeholder' => 'Method Label',
            'otherattr' => '',
        ])
    </td>
    <td>
        @include('components.select', [
            'id' => 'name_' . $id,
            'name' => 'data[' . $id . '][name]',
            'class' => '',
            'mandatory' => true,
            'multiple' => false,
            'margin' => false,
            'label' => '',
            'disabled' => false,
            'options' => Helper::getRouteNames(),
            'selected' => $name ?? '',
        ])
    </td>
    <td class="text-center d-flex justify-content-between align-items-center">
        @if (! (isset($new) && $new))
            <a class="btn btn-info btn-circle" href="{{ route('permissions.edit', urlencode(base64_encode($id))) }}">
                <i class="fas fa-pen"></i>
            </a>
        @endif
        <a href="javascript:void(0)" class="btn btn-danger btn-circle deleteRecord"
            url="{{ isset($new) && $new ? '' : route('permissions.destroy', urlencode(base64_encode($id))) }}">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
