/**
 * Title Component.
 */
const Title = ({
	option: { label = '', elementType = '' }
}) => (
	<>
        <div className="ast-meta-settings-title" data-type={elementType}>
           <h4>{label}</h4>
		</div>
	</>
)

export default Title
