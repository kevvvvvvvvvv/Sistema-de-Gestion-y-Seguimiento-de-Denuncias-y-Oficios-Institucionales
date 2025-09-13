import { useState } from 'react'
import { Link } from '@inertiajs/react'
import { ChevronDown, ChevronUp } from 'lucide-react'

export default function SidebarDropdown({ icon: Icon, label, items }) {
  const [open, setOpen] = useState(false)

  return (
    <div>
      <button
        onClick={() => setOpen(!open)}
        className='flex gap-2 items-center w-full text-left hover:bg-black/10 rounded-md w-full p-2'
      >
        {Icon && <Icon />}
        <p>{label}</p>
        {open ? <ChevronUp className='ml-auto' /> : <ChevronDown className='ml-auto' />}
      </button>

      {open && (
        <div className='ml-8 mt-2 flex flex-col gap-1'>
          {items.map((item, idx) => (
            <Link
              key={idx}
              href={item.href}
              className='font-extralight hover:bg-black/10 rounded-md w-full p-2 border-l-2 border-gray-300'
            >
              {item.text}
            </Link>
          ))}
        </div>
      )}
    </div>
  )
}
