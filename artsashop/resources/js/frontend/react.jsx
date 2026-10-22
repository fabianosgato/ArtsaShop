import {createRoot} from 'react-dom/client';
import ReactTest from './components/ReactTest';

const element = document.getElementById('react-test');

const root = createRoot(element);

root.render(<ReactTest />);
