import Select from "react-select";

export default function SelectInput({ label, options, value, onChange, error, placeholder = "Selecciona una opción" }) {
  // Estilos personalizados para que se vea igual que InputText
  const customStyles = {
    control: (provided, state) => ({
      ...provided,
      borderColor: "#D9D9D9",
      backgroundColor: "#F9F7F5",
      borderRadius: "0.5rem",
      padding: "2px 4px",
      boxShadow: state.isFocused ? "0 0 0 2px #3B82F6" : "none",
      "&:hover": {
        borderColor: "#D9D9D9"
      },
      minHeight: "40px"
    }),
    placeholder: (provided) => ({
      ...provided,
      color: "#9CA3AF"
    }),
    singleValue: (provided) => ({
      ...provided,
      color: "#111827"
    }),
    dropdownIndicator: (provided) => ({
      ...provided,
      color: "#6B7280"
    }),
    indicatorSeparator: () => ({ display: "none" })
  };

  return (
    <div className="mb-5 w-full">
      {label && (
        <label className="block text-sm mb-3">
          {label}
        </label>
      )}
      <Select
        options={options}
        value={options.find((opt) => opt.value === value) || null}
        onChange={(selected) => onChange(selected ? selected.value : "")}
        placeholder={placeholder}
        styles={customStyles}
      />
      {error && (
        <p className="text-red-500 text-sm mt-1">{error}</p>
      )}
    </div>
  );
}