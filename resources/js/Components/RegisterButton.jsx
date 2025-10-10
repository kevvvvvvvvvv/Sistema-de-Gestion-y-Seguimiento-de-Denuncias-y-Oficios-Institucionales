export default function RegisterButton({ onClick, children, type="button", className }) {
  return (
    <div className="flex mt-4">
      <button
        type={type}
        onClick={onClick}
        className={`bg-azulIMTA text-blancoIMTA px-20 py-2 rounded-lg 
                   hover:bg-azulIMTAHover transition duration-200 ease-in-out 
                   hover:-translate-y-1 hover:scale-110 cursor-pointer ${className}`}
      >
        {children}
      </button>
    </div>
  );
}
