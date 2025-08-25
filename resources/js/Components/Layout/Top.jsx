import BackButton from "../BackButton";

export default function Top({ children = "", className = "" }) {
    return (
        <div className={`flex items-center gap-4 mt-8 ml-4 ${className}`}>
            <BackButton />
            <h1 className="text-xl font-bold">{children}</h1>
        </div>
    )
}
