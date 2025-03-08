import { useState } from 'react'
import './App.css'
import UsersTable from './components/UsersTable'

function App() {
  const [count, setCount] = useState(0)

  return (
    <>
      <div className="App">
        <UsersTable />
      </div>
    </>
  )
}

export default App
