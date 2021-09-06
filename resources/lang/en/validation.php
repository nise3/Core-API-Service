<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
        'accepted' => [
            'code' => 1000,
            'message' => 'The :attribute must be accepted.',
        ],
        'active_url' => [
            'code' => 1001,
            'message' => 'The :attribute is not a valid URL.',
        ],
        'after' => [
            'code' => 1002,
            'message' => 'The :attribute must be a date after :date.',
        ],
        'after_or_equal' => [
            'code' => 1003,
            'message' => 'The :attribute must be a date after or equal to :date.',
        ],
        'alpha' => [
            'code' => 1004,
            'message' => 'The :attribute may only contain letters.',
        ],
        'alpha_dash' => [
            'code' => 1005,
            'message' => 'The :attribute may only contain letters, numbers, dashes and underscores.',
        ],
        'alpha_num' => [
            'code' => 1006,
            'message' => 'The :attribute may only contain letters and numbers.',
        ],
        'array' => [
            'code' => 1007,
            'message' => 'The :attribute must be an array.',
        ],
        'before' => [
            'code' => 1008,
            'message' => 'The :attribute must be a date before :date.',
        ],
        'before_or_equal' => [
            'code' => 1009,
            'message' => 'The :attribute must be a date before or equal to :date.',
        ],
        'between' => [
            'code' => 1010,
            0 => [
                'numeric' => [
                    'code' => 1011,
                    'message' => 'The :attribute must be between :min and :max.',
                ],
                'file' => [
                    'code' => 1012,
                    'message' => 'The :attribute must be between :min and :max kilobytes.',
                ],
                'string' => [
                    'code' => 1013,
                    'message' => 'The :attribute must be between :min and :max characters.',
                ],
                'array' => [
                    'code' => 1014,
                    'message' => 'The :attribute must have between :min and :max items.',
                ],
            ],
        ],
        'boolean' => [
            'code' => 1011,
            'message' => 'The :attribute field must be true or false.',
        ],
        'confirmed' => [
            'code' => 1012,
            'message' => 'The :attribute confirmation does not match.',
        ],
        'date' => [
            'code' => 1013,
            'message' => 'The :attribute is not a valid date.',
        ],
        'date_equals' => [
            'code' => 1014,
            'message' => 'The :attribute must be a date equal to :date.',
        ],
        'date_format' => [
            'code' => 1015,
            'message' => 'The :attribute does not match the format :format.',
        ],
        'different' => [
            'code' => 1016,
            'message' => 'The :attribute and :other must be different.',
        ],
        'digits' => [
            'code' => 1017,
            'message' => 'The :attribute must be :digits digits.',
        ],
        'digits_between' => [
            'code' => 1018,
            'message' => 'The :attribute must be between :min and :max digits.',
        ],
        'dimensions' => [
            'code' => 1019,
            'message' => 'The :attribute has invalid image dimensions.',
        ],
        'distinct' => [
            'code' => 1020,
            'message' => 'The :attribute field has a duplicate value.',
        ],
        'email' => [
            'code' => 1021,
            'message' => 'The :attribute must be a valid email address.',
        ],
        'ends_with' => [
            'code' => 1022,
            'message' => 'The :attribute must end with one of the following: :values',
        ],
        'exists' => [
            'code' => 1023,
            'message' => 'The selected :attribute is invalid.',
        ],
        'file' => [
            'code' => 1024,
            'message' => 'The :attribute must be a file.',
        ],
        'filled' => [
            'code' => 1025,
            'message' => 'The :attribute field must have a value.',
        ],
        'gt' => [
            'code' => 1026,
            0 => [
                'numeric' => [
                    'code' => 1027,
                    'message' => 'The :attribute must be greater than :value.',
                ],
                'file' => [
                    'code' => 1028,
                    'message' => 'The :attribute must be greater than :value kilobytes.',
                ],
                'string' => [
                    'code' => 1029,
                    'message' => 'The :attribute must be greater than :value characters.',
                ],
                'array' => [
                    'code' => 1030,
                    'message' => 'The :attribute must have more than :value items.',
                ],
            ],
        ],
        'gte' => [
            'code' => 1027,
            0 => [
                'numeric' => [
                    'code' => 1028,
                    'message' => 'The :attribute must be greater than or equal :value.',
                ],
                'file' => [
                    'code' => 1029,
                    'message' => 'The :attribute must be greater than or equal :value kilobytes.',
                ],
                'string' => [
                    'code' => 1030,
                    'message' => 'The :attribute must be greater than or equal :value characters.',
                ],
                'array' => [
                    'code' => 1031,
                    'message' => 'The :attribute must have :value items or more.',
                ],
            ],
        ],
        'image' => [
            'code' => 1028,
            'message' => 'The :attribute must be an image.',
        ],
        'in' => [
            'code' => 1029,
            'message' => 'The selected :attribute is invalid.',
        ],
        'in_array' => [
            'code' => 1030,
            'message' => 'The :attribute field does not exist in :other.',
        ],
        'integer' => [
            'code' => 1031,
            'message' => 'The :attribute must be an integer.',
        ],
        'ip' => [
            'code' => 1032,
            'message' => 'The :attribute must be a valid IP address.',
        ],
        'ipv4' => [
            'code' => 1033,
            'message' => 'The :attribute must be a valid IPv4 address.',
        ],
        'ipv6' => [
            'code' => 1034,
            'message' => 'The :attribute must be a valid IPv6 address.',
        ],
        'json' => [
            'code' => 1035,
            'message' => 'The :attribute must be a valid JSON string.',
        ],
        'lt' => [
            'code' => 1036,
            0 => [
                'numeric' => [
                    'code' => 1037,
                    'message' => 'The :attribute must be less than :value.',
                ],
                'file' => [
                    'code' => 1038,
                    'message' => 'The :attribute must be less than :value kilobytes.',
                ],
                'string' => [
                    'code' => 1039,
                    'message' => 'The :attribute must be less than :value characters.',
                ],
                'array' => [
                    'code' => 1040,
                    'message' => 'The :attribute must have less than :value items.',
                ],
            ],
        ],
        'lte' => [
            'code' => 1037,
            0 => [
                'numeric' => [
                    'code' => 1038,
                    'message' => 'The :attribute must be less than or equal :value.',
                ],
                'file' => [
                    'code' => 1039,
                    'message' => 'The :attribute must be less than or equal :value kilobytes.',
                ],
                'string' => [
                    'code' => 1040,
                    'message' => 'The :attribute must be less than or equal :value characters.',
                ],
                'array' => [
                    'code' => 1041,
                    'message' => 'The :attribute must not have more than :value items.',
                ],
            ],
        ],
        'max' => [
            'code' => 1038,
            0 => [
                'numeric' => [
                    'code' => 1039,
                    'message' => 'The :attribute may not be greater than :max.',
                ],
                'file' => [
                    'code' => 1040,
                    'message' => 'The :attribute may not be greater than :max kilobytes.',
                ],
                'string' => [
                    'code' => 1041,
                    'message' => 'The :attribute may not be greater than :max characters.',
                ],
                'array' => [
                    'code' => 1042,
                    'message' => 'The :attribute may not have more than :max items.',
                ],
            ],
        ],
        'mimes' => [
            'code' => 1039,
            'message' => 'The :attribute must be a file of type: :values.',
        ],
        'mimetypes' => [
            'code' => 1040,
            'message' => 'The :attribute must be a file of type: :values.',
        ],
        'min' => [
            'code' => 1041,
            0 => [
                'numeric' => [
                    'code' => 1042,
                    'message' => 'The :attribute must be at least :min.',
                ],
                'file' => [
                    'code' => 1043,
                    'message' => 'The :attribute must be at least :min kilobytes.',
                ],
                'string' => [
                    'code' => 1044,
                    'message' => 'The :attribute must be at least :min characters.',
                ],
                'array' => [
                    'code' => 1045,
                    'message' => 'The :attribute must have at least :min items.',
                ],
            ],
        ],
        'not_in' => [
            'code' => 1042,
            'message' => 'The selected :attribute is invalid.',
        ],
        'not_regex' => [
            'code' => 1043,
            'message' => 'The :attribute format is invalid.',
        ],
        'numeric' => [
            'code' => 1044,
            0 => [
                0 => [
                    'code' => 1045,
                    'message' => 'The :attribute must be a number.',
                ],
            ],
        ],
        'password' => [
            'code' => 1045,
            'message' => 'The password is incorrect.',
        ],
        'present' => [
            'code' => 1046,
            'message' => 'The :attribute field must be present.',
        ],
        'regex' => [
            'code' => 1047,
            'message' => 'The :attribute format is invalid.',
        ],
        'required' => [
            'code' => 1048,
            'message' => 'The :attribute field is required.',
        ],
        'required_if' => [
            'code' => 1049,
            'message' => 'The :attribute field is required when :other is :value.',
        ],
        'required_unless' => [
            'code' => 1050,
            'message' => 'The :attribute field is required unless :other is in :values.',
        ],
        'required_with' => [
            'code' => 1051,
            'message' => 'The :attribute field is required when :values is present.',
        ],
        'required_with_all' => [
            'code' => 1052,
            'message' => 'The :attribute field is required when :values are present.',
        ],
        'required_without' => [
            'code' => 1053,
            'message' => 'The :attribute field is required when :values is not present.',
        ],
        'required_without_all' => [
            'code' => 1054,
            'message' => 'The :attribute field is required when none of :values are present.',
        ],
        'same' => [
            'code' => 1055,
            'message' => 'The :attribute and :other must match.',
        ],
        'size' => [
            'code' => 1056,
            0 => [
                'numeric' => [
                    'code' => 1057,
                    'message' => 'The :attribute must be :size.',
                ],
                'file' => [
                    'code' => 1058,
                    'message' => 'The :attribute must be :size kilobytes.',
                ],
                'string' => [
                    'code' => 1059,
                    'message' => 'The :attribute must be :size characters.',
                ],
                'array' => [
                    'code' => 1060,
                    'message' => 'The :attribute must contain :size items.',
                ],
            ],
        ],
        'starts_with' => [
            'code' => 1057,
            'message' => 'The :attribute must start with one of the following: :values',
        ],
        'string' => [
            'code' => 1058,
            'message' => 'The :attribute must be a string.',
        ],
        'timezone' => [
            'code' => 1059,
            'message' => 'The :attribute must be a valid zone.',
        ],
        'unique' => [
            'code' => 1060,
            'message' => 'The :attribute has already been taken.',
        ],
        'uploaded' => [
            'code' => 1061,
            'message' => 'The :attribute failed to upload.',
        ],
        'url' => [
            'code' => 1062,
            'message' => 'The :attribute format is invalid.',
        ],
        'uuid' => [
            'code' => 1063,
            'message' => 'The :attribute must be a valid UUID.',
        ],
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
