
const { ToggleControl } = wp.components;

const AstCheckboxControl = ( props ) => {
    return (
        <ToggleControl
            className = { props.name }
            label={ props.label }
            checked={  props.value  }
            onChange={ (val)=>{
                val = ( true === val ) ? 'disabled' : '';
            props.onChange(val)} }
        />
    );
}

export default AstCheckboxControl;
