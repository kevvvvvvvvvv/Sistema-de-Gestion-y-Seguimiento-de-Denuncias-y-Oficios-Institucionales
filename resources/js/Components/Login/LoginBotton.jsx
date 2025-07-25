export default function PrimaryButton({
    className = '',
    disabled,
    children,
    ...props
}) {
    return (
        <button
            {...props}
            className={
                `w-full items-center rounded-md border border-transparent bg-azulIMTA px-4 py-4 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-azulIMTAHover focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900 ${
                    disabled && 'opacity-25'
                } ` + className
            }

            disabled={disabled}
        >
            {children}
        </button>
    );
}
