export default function Button({
    type = "button",
    onClick,
    text,
    className = "",
    buttonClassName = ""
}) {
    return (
        <div className={className}>
            <button
                type={type}
                onClick={onClick}
                className={`
                    px-4
                    py-2
                    rounded-md
                    text-md
                    font-medium
                    bg-green-600
                    text-white
                    hover:bg-green-700
                    focus:outline-none
                    focus:ring-2
                    focus:ring-green-500
                    transition
                    ${buttonClassName}
                `}
            >
                {text}
            </button>
        </div>
    );
}
