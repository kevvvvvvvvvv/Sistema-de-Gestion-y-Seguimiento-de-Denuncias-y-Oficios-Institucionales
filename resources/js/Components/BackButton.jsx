export default function BackButton({ children = "< Atrás", className = "" }) {
  return (
    <button
      type="button"
      onClick={() => window.history.back()}
      className={`px-4 py-2 font-bold bg-white text-black border border-black rounded-xl hover:bg-gray-700 hover:text-white transition ${className}`}
    >
      {children}
    </button>
  );
}
