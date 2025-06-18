module.exports = {
  ci: {
    collect: {
      url: ['http://localhost:8080/'],
    },
    assert: {
      assertions: {
        'categories:performance': ['error', {minScore: 0.8}],
        'categories:accessibility': ['error', {minScore: 0.92}],
        'categories:best-practices': ['error', {minScore: 0.9}],
        'categories:seo': ['error', {minScore: 0.9}],
      }
    }
  }
};
