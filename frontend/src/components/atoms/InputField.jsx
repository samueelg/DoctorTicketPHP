export default function InputField({ label, type, value, onChange, placeholder, icon }) {
    return (
        <div className="input-container">
            <label>{label}</label>

            <div className="input-wrapper">
                <input 
                    type={type}
                    value={value}
                    onChange={onChange}
                    placeholder={placeholder}
                />

                {icon && <i className={icon}></i>}
            </div>
        </div>
    );
}
