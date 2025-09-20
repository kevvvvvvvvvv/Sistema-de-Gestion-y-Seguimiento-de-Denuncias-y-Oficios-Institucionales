export default function Card({
    title,
    data,
    title2 = "",
    data2 = "",
    title3 = "",
    data3 = ""
}) {
  return (
    <div className="grid grid-cols-3 bg-blancoIMTA mb-6 p-6 rounded-lg">
        <div className="flex flex-col items-center">
            <h2 className="text-3xl">{data}</h2>
            <h3 className="text-sm font-bold text-center">{title}</h3>
        </div>
        <div className="flex flex-col items-center">
            <h2 className="text-3xl">{data2}</h2>
            <h3 className="text-sm font-bold text-center">{title2}</h3>
        </div>
        <div className="flex flex-col items-center">
            <h2 className="text-3xl">{data3}</h2>
            <h3 className="text-sm font-bold text-center">{title3}</h3>
        </div>
            
    </div>
  );
}
