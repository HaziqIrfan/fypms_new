<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'student_submissions' => [
        'name' => 'Student Submissions',
        'index_title' => 'StudentSubmissions List',
        'new_title' => 'New Student submission',
        'create_title' => 'Create StudentSubmission',
        'edit_title' => 'Edit StudentSubmission',
        'show_title' => 'Show StudentSubmission',
        'inputs' => [
            'file_path' => 'File Path',
            'submission_id' => 'Submission',
            'student_id' => 'Student',
        ],
    ],

    'evaluations' => [
        'name' => 'Evaluations',
        'index_title' => 'Evaluations List',
        'new_title' => 'New Evaluation',
        'create_title' => 'Create Evaluation',
        'edit_title' => 'Edit Evaluation',
        'show_title' => 'Show Evaluation',
        'inputs' => [
            'title' => 'Title',
            'rubric_file_path' => 'Rubric File Path',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
        ],
    ],

    'evaluation_results' => [
        'name' => 'Evaluation Results',
        'index_title' => 'EvaluationResults List',
        'new_title' => 'New Evaluation result',
        'create_title' => 'Create EvaluationResult',
        'edit_title' => 'Edit EvaluationResult',
        'show_title' => 'Show EvaluationResult',
        'inputs' => [
            'mark' => 'Mark',
            'evaluation_id' => 'Evaluation',
            'student_id' => 'Student',
            'evaluator_id' => 'Evaluator',
        ],
    ],

    'evaluators' => [
        'name' => 'Evaluators',
        'index_title' => 'Evaluators List',
        'new_title' => 'New Evaluator',
        'create_title' => 'Create Evaluator',
        'edit_title' => 'Edit Evaluator',
        'show_title' => 'Show Evaluator',
        'inputs' => [
            'user_id' => 'User',
        ],
    ],

    'logbooks' => [
        'name' => 'Logbooks',
        'index_title' => 'Logbooks List',
        'new_title' => 'New Logbook',
        'create_title' => 'Create Logbook',
        'edit_title' => 'Edit Logbook',
        'show_title' => 'Show Logbook',
        'inputs' => [
            'datetime' => 'Datetime',
            'week' => 'Week',
            'approval_date' => 'Approval Date',
            'description' => 'Description',
            'comment' => 'Comment',
            'student_id' => 'Student',
        ],
    ],

    'posts' => [
        'name' => 'Posts',
        'index_title' => 'Posts List',
        'new_title' => 'New Post',
        'create_title' => 'Create Post',
        'edit_title' => 'Edit Post',
        'show_title' => 'Show Post',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'file_path' => 'File Path',
        ],
    ],

    'students' => [
        'name' => 'Students',
        'index_title' => 'Students List',
        'new_title' => 'New Student',
        'create_title' => 'Create Student',
        'edit_title' => 'Edit Student',
        'show_title' => 'Show Student',
        'inputs' => [
            'sv_name' => 'Sv Name',
            'project_title' => 'Project Title',
            'psm_status' => 'Psm Status',
            'year' => 'Year',
            'program' => 'Program',
            'pa_name' => 'Pa Name',
            'user_id' => 'User',
        ],
    ],

    'submissions' => [
        'name' => 'Submissions',
        'index_title' => 'Submissions List',
        'new_title' => 'New Submission',
        'create_title' => 'Create Submission',
        'edit_title' => 'Edit Submission',
        'show_title' => 'Show Submission',
        'inputs' => [
            'title' => 'Title',
            'description' => 'Description',
            'due_date' => 'Due Date',
            'start_date' => 'Start Date',
        ],
    ],

    'supervisors' => [
        'name' => 'Supervisors',
        'index_title' => 'Supervisors List',
        'new_title' => 'New Supervisor',
        'create_title' => 'Create Supervisor',
        'edit_title' => 'Edit Supervisor',
        'show_title' => 'Show Supervisor',
        'inputs' => [
            'background' => 'Background',
            'availability' => 'Availability',
            'user_id' => 'User',
            'student_id' => 'Student',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
