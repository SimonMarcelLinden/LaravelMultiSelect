@isset($preSelect)
    <multiselect :values="{{json_encode($values)}}" :pre-select="{{json_encode($preSelect)}}"></multiselect>
@else
    <multiselect :values="{{json_encode($values)}}"></multiselect>
@endif
