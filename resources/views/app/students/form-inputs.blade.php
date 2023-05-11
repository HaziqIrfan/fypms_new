@php $editing = isset($student) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="sv_name"
            label="Sv Name"
            :value="old('sv_name', ($editing ? $student->sv_name : ''))"
            maxlength="255"
            placeholder="Sv Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="project_title"
            label="Project Title"
            :value="old('project_title', ($editing ? $student->project_title : ''))"
            maxlength="255"
            placeholder="Project Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="psm_status"
            label="Psm Status"
            :value="old('psm_status', ($editing ? $student->psm_status : ''))"
            maxlength="255"
            placeholder="Psm Status"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="year"
            label="Year"
            :value="old('year', ($editing ? $student->year : ''))"
            maxlength="255"
            placeholder="Year"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="program"
            label="Program"
            :value="old('program', ($editing ? $student->program : ''))"
            maxlength="255"
            placeholder="Program"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="pa_name"
            label="Pa Name"
            :value="old('pa_name', ($editing ? $student->pa_name : ''))"
            maxlength="255"
            placeholder="Pa Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $student->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
