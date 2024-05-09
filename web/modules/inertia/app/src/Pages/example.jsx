import PropTypes from "prop-types";

export default function Example({ node }) {
  console.log(node);
  return (
    <div>
      <h1>Inertia template loaded</h1>
      <h2>Title: {node.title}</h2>
      <div dangerouslySetInnerHTML={{ __html: node.description }} />
    </div>
  );
}

Example.propTypes = {
  node: PropTypes.shape({
    title: PropTypes.string.isRequired,
    description: PropTypes.string.isRequired,
  }),
};
