@php $editing = isset($studentSubmission) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="file_path"
            label="File Path"
            maxlength="255"
            required
            >{{ old('file_path', ($editing ? $studentSubmission->file_path :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="submission_id" label="Submission" required>
            @php $selected = old('submission_id', ($editing ? $studentSubmission->submission_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Submission</option>
            @foreach($submissions as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="student_id" label="Student" required>
            @php $selected = old('student_id', ($editing ? $studentSubmission->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Student</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
