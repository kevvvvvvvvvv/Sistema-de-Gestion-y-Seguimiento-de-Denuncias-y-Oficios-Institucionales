export default function PDFButton({ onClick, children }) {
  return (
    <div className="flex mt-4">
      <button
        type="button"
        onClick={onClick}
        className="bg-azulIMTA text-blancoIMTA px-4 py-2 mt-8 rounded-lg 
                   hover:bg-azulIMTAHover transition duration-200 ease-in-out 
                   hover:-translate-y-1 hover:scale-110 cursor-pointer"
      >
        {children}
      </button>
    </div>
  );
}
