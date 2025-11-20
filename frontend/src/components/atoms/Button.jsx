export default function Button({type, onClick, text}){
    return(
        <button type={type} onClick={onClick}>
            {text}
        </button>
    );
}