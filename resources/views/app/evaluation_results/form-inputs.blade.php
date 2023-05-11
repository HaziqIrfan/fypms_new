@php $editing = isset($evaluationResult) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mark"
            label="Mark"
            :value="old('mark', ($editing ? $evaluationResult->mark : ''))"
            maxlength="255"
            placeholder="Mark"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="evaluation_id" label="Evaluation" required>
            @php $selected = old('evaluation_id', ($editing ? $evaluationResult->evaluation_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Evaluation</option>
            @foreach($evaluations as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="student_id" label="Student" required>
            @php $selected = old('student_id', ($editing ? $evaluationResult->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Student</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="evaluator_id" label="Evaluator" required>
            @php $selected = old('evaluator_id', ($editing ? $evaluationResult->evaluator_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Evaluator</option>
            @foreach($evaluators as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
