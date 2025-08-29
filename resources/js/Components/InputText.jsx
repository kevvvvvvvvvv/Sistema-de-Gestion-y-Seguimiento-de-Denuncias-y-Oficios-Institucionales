export default function InputText({
    value,
    onChange,
    placeholder = "",
    type = "text",
    name,
    id,
    className = "",
    description = ""
  }) {
    return (
      <div className="mb-5">
        <p className="mb-3 text-sm">{description}</p>
        <input
          type={type}
          name={name}
          id={id}
          value={value}
          onChange={onChange}
          placeholder={placeholder}
          className={`border border-[#D9D9D9] bg-[#F9F7F5] rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 ${className}`}
        />
      </div>
    );
  }
  