export default function InputTextArea({
    label,
    value,
    onChange,
    placeholder = "",
    name,
    id,
    rows = 4,
    className = "",
    description = "",
    error = ""
}) {
    return (
        <div className="mb-5 w-full">
        {label && (
            <label htmlFor={id} className="block text-sm mb-3">
            {label}
            </label>
        )}
        {description && (
            <p className="mb-3 text-sm">{description}</p>
        )}
        <textarea
            name={name}
            id={id}
            rows={rows}
            value={value}
            onChange={onChange}
            placeholder={placeholder}
            className={` w-3/4 border border-[#D9D9D9] bg-[#F9F7F5] rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 resize-none ${className}`}
        />
        {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
        </div>
    );
}