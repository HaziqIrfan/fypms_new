@php $editing = isset($logbook) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.date
            name="datetime"
            label="Datetime"
            value="{{ old('datetime', ($editing ? optional($logbook->datetime)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="week"
            label="Week"
            :value="old('week', ($editing ? $logbook->week : ''))"
            maxlength="255"
            placeholder="Week"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="approval_date"
            label="Approval Date"
            value="{{ old('approval_date', ($editing ? optional($logbook->approval_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="description"
            label="Description"
            value="{{ old('description', ($editing ? optional($logbook->description)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="comment"
            label="Comment"
            :value="old('comment', ($editing ? $logbook->comment : ''))"
            maxlength="255"
            placeholder="Comment"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="student_id" label="Student" required>
            @php $selected = old('student_id', ($editing ? $logbook->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Student</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
