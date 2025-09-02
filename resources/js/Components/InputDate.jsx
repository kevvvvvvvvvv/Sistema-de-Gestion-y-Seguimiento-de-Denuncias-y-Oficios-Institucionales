import { useState } from "react";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";

export default function InputDate({
    value,
    onChange,
    placeholder = "Selecciona una fecha",
    name,
    id,
    className = "",
    description = "",
    error = ""
}) {
  
  const [selectedDate, setSelectedDate] = useState(value || null);

  const handleChange = (date) => {
    setSelectedDate(date);
        if (onChange) {
            onChange(date);
    }
  };

  return (
    <div className="mb-5">
        <p className="mb-3 text-sm">{description}</p>
        <DatePicker
            selected={selectedDate}
            onChange={handleChange}
            placeholderText={placeholder}
            dateFormat="dd/MM/yyyy"
            name={name}
            id={id}
            className={`w-full border border-[#D9D9D9] bg-[#F9F7F5] rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-500 ${className}`}
            showMonthDropdown
            showYearDropdown
            scrollableYearDropdown
            yearDropdownItemNumber={50}
        />
        {error && <p className="text-red-500 text-sm mt-1">{error}</p>}
    </div>
  );
}
